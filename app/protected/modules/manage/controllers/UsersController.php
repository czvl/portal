<?php

class UsersController extends Controller
{

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
                'roles' => array(User::ROLE_MANAGER),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array(User::ROLE_ADMIN),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $user = $this->loadModel($id);
        $this->performAjaxValidation($user);
        
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {

                UserToCities::model()->deleteAll('user_id=:user_id', [
                    ':user_id' => $user->id,
                ]);
                UserToCvCategories::model()->deleteAll('user_id=:user_id', [
                    ':user_id' => $user->id,
                ]);

                if(isset($_POST['categories']) && is_array($_POST['categories'])) {
                    foreach($_POST['categories'] as $categoryId) {
                        $userToCvCategory = new UserToCvCategories();
                        $userToCvCategory->user_id = $user->id;
                        $userToCvCategory->cv_category_id = $categoryId;
                        $userToCvCategory->save();
                    }
                }
                if(isset($_POST['cities']) && is_array($_POST['cities'])) {
                    foreach($_POST['cities'] as $cityIndex) {
                        $userToCity = new UserToCities();
                        $userToCity->user_id = $user->id;
                        $userToCity->city_index = $cityIndex;
                        $userToCity->save();
                    }
                }
                Yii::app()->user->setFlash('success', Yii::t('main', 'Successfully changed!'));
            }
        }

        $this->render('update', array('model' => $user));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
