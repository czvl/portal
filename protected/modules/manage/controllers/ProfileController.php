<?php

class ProfileController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'create', 'update'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex()
    {
        $userId = Yii::app()->user->id;
        $model = User::model()->findByPk($userId);
        $model->scenario = 'update';
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            
            $userSalt = base64_encode(mcrypt_create_iv(30));
            $model->password = crypt($_POST['User']['password_new'], $userSalt);
            
            if ($model->save()) {
                
                $log = new Log();
                $log->action = 'change_pass';
                $log->save();
                
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Ваш пароль був збережений!');
                $this->refresh();
            }
        }
        
        $this->render('index', array('model' => $model));
    }


    /**
     * Performs the AJAX validation.
     * @param CvList $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
