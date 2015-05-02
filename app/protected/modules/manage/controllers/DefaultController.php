<?php

class DefaultController extends Controller
{
    
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }
    
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('index', 'logout'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
    
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                //$this->redirect(Yii::app()->user->returnUrl);
                $this->redirect(array('/manage/'));
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('/manage/login'));
    }

}
