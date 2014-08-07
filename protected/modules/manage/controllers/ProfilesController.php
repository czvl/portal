<?php

class ProfilesController extends Controller
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
            array('allow',
                'actions' => array('delete'),
                'roles' => array('administrator'),
            ),
            array('deny',
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
        $status = new CvStatuses();

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'status-form') {
            echo CActiveForm::validate($status);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['CvStatuses'])) {
            $status->attributes = $_POST['CvStatuses'];
            if ($status->validate() && $status->save()) {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Ваш статус був доданий!');
                $this->redirect(array('/manage/profiles/view/', 'id' => $id, '#' => 'statuses'));
            }
        }
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'status' => $status
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CvList;
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['CvList'])) {
            $model->attributes = $_POST['CvList'];
            $model->categories = $_POST['CvList']['categoryIds'];
            $model->citiesResidence = $_POST['CvList']['residenciesIds'];
            $model->driverLicensesTypes = $_POST['CvList']['driverLicensesIds'];
            $model->citiesJobLocations = $_POST['CvList']['jobLocationsIds'];
            $model->assistanceTypes = $_POST['CvList']['assistanceIds'];
            if ($model->saveWithRelated(array('categories', 'citiesResidence', 'citiesJobLocations', 'driverLicensesTypes', 'assistanceTypes'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        $this->performAjaxValidation($model);

        if (isset($_POST['CvList'])) {
            $model->attributes = $_POST['CvList'];
            $model->categories = $_POST['CvList']['categoryIds'];
            $model->citiesResidence = $_POST['CvList']['residenciesIds'];
            $model->driverLicensesTypes = $_POST['CvList']['driverLicensesIds'];
            $model->citiesJobLocations = $_POST['CvList']['jobLocationsIds'];
            $model->assistanceTypes = $_POST['CvList']['assistanceIds'];
            if ($model->saveWithRelated(array('categories', 'citiesResidence', 'citiesJobLocations', 'driverLicensesTypes', 'assistanceTypes'))) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
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
        $criteria = new CDbCriteria();
        
        if (($status = $this->getVariable('status')) !== false && !empty($status)) {
            $criteria->condition = 'status = :status';
            $criteria->params = array(':status' => $status);
        }
//        if (($locations = $this->getVariable('locations')) !== false && !empty($locations)) {
//            $criteria->with = array('citiesJobLocations');
//            $criteria->together = true;
//            $criteria->addInCondition('city_id', $locations);
//        }
        
        $dataProvider = new CActiveDataProvider('CvList', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'page',
            ),
                )
        );

        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CvList the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CvList::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CvList $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cv-list-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
