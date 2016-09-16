<?php

class ProfilesController extends Controller
{

    public $toExport = [];
    protected $filters = [];

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
            array(
                'allow',
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('allow',
                 'actions' => array('view', 'update'),
                  'expression' => array('ProfilesController', 'groupFilter')
                 ),
            array('allow',
                 'actions' => array('create', 'export'),
                  'roles' => array('volunteer', 'volunteer_ato')
                 ),

            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array('administrator', 'manager'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function groupFilter() {

       $loadModel = new CvList();
       $model = $loadModel->find('id=' . $_GET['id']);
       // If profile is Ato profile
        if(in_array('3', $model->applicantTypeIds)) {
           // Check if user Ato Volont or manager/admin
           if(Yii::app()->user->checkAccess(User::ROLE_VOLONT_ATO)) {
               return true;
               // if no - access denied
           }
            else {
              return false;
           }
       }
       // if categories is empty - grant access
       if(empty($model->applicantTypeIds)) {
           return true;
       }
       // if profile not Ato - grant access
        else {
            return true;
       }
    }


    public function behaviors()
    {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelview.EExcelBehavior',
            ),
        );
    }


    public function init()
    {
        $cookies = Yii::app()->request->getCookies();
        if (!is_null($cookies['toExport']) && !empty($cookies['toExport']->value)) {
            $this->toExport = explode(',', $cookies['toExport']->value);
        }
    }


    /**
     * Displays a particular model.
     *
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);
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

                $log = new Log();
                $log->action = 'add_status_to_user_' . $id;
                $log->save();

                // Send email when add status
                if ($model->recruiter_id and $model->recruiter_id != Yii::app()->user->id) {
                    $user = User::model()->findByPk($model->recruiter_id);
                    $comment = $status->message;
                    $sendTo = $user->email;
                    $body = "До вашої анкети був доданий новий коментар - {$comment}";
                    $this->sendMail("Новий коментар до анкети {$id}", $body, $sendTo, $id);
                }

                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Ваш статус був доданий!');
                $this->redirect(array('/manage/profiles/view/', 'id' => $id, '#' => 'statuses'));
            }
        }

        if (isset($_POST['CvList'])) {
            $model->status = $_POST['CvList']['status'];
            if ($model->save()) {

                $log = new Log();
                $log->action = 'change_status_to_user_' . $id . "_to_" . $_POST['CvList']['status'];
                $log->save();

                //Send mail notify if status update
                if ($model->recruiter_id and $model->recruiter_id != Yii::app()->user->id) {
                    $user = User::model()->findByPk($model->recruiter_id);
                    $status = Yii::app()->config->statuses[$_POST['CvList']['status']];
                    $sendTo = $user->email;
                    $body = "Статус вашої анкети було змінено. Новий статус - {$status}";
                    $this->sendMail("Новий статус анкети {$id}", $body, $sendTo, $id);
                }


                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Статус анкети був оновлений!');
                $this->redirect(array('/manage/profiles/view/', 'id' => $id));
            } else {
                $errors = $model->getErrors();
                $errString = '';
                foreach ($errors as $e) {
                    $errString .= implode(", ", $e);
                }

                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, 'Виникли помилки: ' . $errString);
            }
        }

        $statuses = CvStatuses::model()->findAll(array(
            'condition' => 'cv_id=:cv_id',
            'params' => array(':cv_id' => $id),
            'order' => 'added_time DESC'
        ));

        $criteria = new CDbCriteria();
        $criteria->with = [
            'positions' => [
                'together' => true
            ],
        ];
        $criteria->addInCondition('positions.id', $model->positionsIds);
        $criteria->addInCondition('city_id', $model->jobLocationsIds);

        $vacanciesDataProvider = new CActiveDataProvider('Vacancy', [
                'criteria' => $criteria,
            ]
        );
        $vacanciesDataProvider->sort = false;

        $this->render('view', array(
            'model' => $model,
            'status' => $status,
            'statuses' => $statuses,
            'vacanciesDataProvider' => $vacanciesDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CvList();

        $this->performAjaxValidation($model);

        if (isset($_POST['CvList'])) {

            $model->attributes = $_POST['CvList'];

            $result = array();
            $t = false;

            if (!Yii::app()->db->currentTransaction) {
                $t = Yii::app()->db->beginTransaction();
            }

            if ($model->save()) {
                if (!empty($_POST['CvList']['residenciesIds'])) {
                    foreach ($_POST['CvList']['residenciesIds'] as $r) {
                        $residence = new CvToResidence();
                        $residence->cv_id = $model->id;
                        $residence->city_id = $r;
                        if (!$residence->save()) {
                            $result[] = false;
                        }
                    }
                }

                if (!empty($_POST['CvList']['driverLicensesIds'])) {
                    foreach ($_POST['CvList']['driverLicensesIds'] as $dl) {
                        $license = new CvToDriverLicense();
                        $license->cv_id = $model->id;
                        $license->license_id = $dl;
                        if (!$license->save()) {
                            $result[] = false;
                        }
                    }
                }

                if (!empty($_POST['CvList']['jobLocationsIds'])) {
                    foreach ($_POST['CvList']['jobLocationsIds'] as $jl) {
                        $jobLocation = new CvToJobLocation();
                        $jobLocation->cv_id = $model->id;
                        $jobLocation->city_id = $jl;
                        if (!$jobLocation->save()) {
                            $result[] = false;
                        }
                    }
                }

                if (!empty($_POST['CvList']['assistanceIds'])) {
                    foreach ($_POST['CvList']['assistanceIds'] as $ai) {
                        $assistance = new CvToAssistance();
                        $assistance->cv_id = $model->id;
                        $assistance->assistance_type_id = $ai;
                        if (!$assistance->save()) {
                            $result[] = false;
                        }
                    }
                }

            } else {
                $result[] = false;
            }

            if ($t && !in_array(false, $result)) {
                $t->commit();

                $log = new Log();
                $log->action = 'add_user_' . $model->id;
                $log->save();

                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Анкета була додана!');

                $this->redirect(array('index'));
            } else {
                $t->rollback();
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Profiles with incorrect date
     */
    public function actionInvalid()
    {
        $criteria = new CDbCriteria();

        $criteria->addCondition([
            'category_id IS NULL OR
                citiesJobLocations_citiesJobLocations.city_id IS NULL OR
                citiesResidence_citiesResidence.city_id IS NULL OR
                position_id IS NULL',
        ]);
        $criteria->addCondition('is_active="yes"');
        $criteria->with = [
            'categories',
            'citiesJobLocations',
            'citiesResidence',
            'positions',
        ];
        $criteria->together = true;

        $dataProvider = new CActiveDataProvider('CvList', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 20,
                ),
            )
        );

        $this->render('invalid', array('dataProvider' => $dataProvider));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['CvList'])) {
            $model->attributes = $_POST['CvList'];
            $model->categories = $_POST['CvList']['categoryIds'];
            $model->positions = $_POST['CvList']['positionsIds'];
            $model->citiesResidence = $_POST['CvList']['residenciesIds'];
            $model->driverLicensesTypes = $_POST['CvList']['driverLicensesIds'];
            $model->citiesJobLocations = $_POST['CvList']['jobLocationsIds'];
            $model->assistanceTypes = $_POST['CvList']['assistanceIds'];
            $model->desiredPositions = $_POST['CvList']['desiredPositionsIds'];
            $model->applicantTypes = $_POST['CvList']['applicantTypeIds'];
            $model->status = $_POST['CvList']['status'];

            if ($model->saveWithRelated(array(
                'categories',
                'positions',
                'citiesResidence',
                'citiesJobLocations',
                'driverLicensesTypes',
                'assistanceTypes',
                'desiredPositions',
                'applicantTypes',
            ))
            ) {

                $log = new Log();
                $log->action = 'update_user_info_' . $id;
                $log->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {

            $model = $this->loadModel($id);
            $model->is_active = CvList::IS_ACTIVE_DELETED;
            $model->save(false);

            $log = new Log();
            $log->action = "delete_user_" . $id;
            $log->save();

            $this->redirect(array('index'));
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    protected function removeMark()
    {
        unset($_GET['post']);

        return $_GET;
    }


    protected function prepareFilter()
    {
        if (isset($_GET['post'])) {
            $get = $this->removeMark();
            $this->filters = UsersFilter::model()->setFilter(Yii::app()->user->id, $get);

            Yii::app()->cache->set('filter_' . Yii::app()->user->id, $this->filters);
            $this->redirect(Yii::app()->createUrl('manage/profiles/index') . '?' . http_build_query($get));
        } else {
            $content = Yii::app()->cache->get('filter_' . Yii::app()->user->id);

            if ($content === false) {
                $content = UsersFilter::model()->getFilter(Yii::app()->user->id);
                Yii::app()->cache->set('filter_' . Yii::app()->user->id, $content);
            }

            if (!sizeof($_GET) && sizeof($content)) {
                $this->redirect(Yii::app()->createUrl('manage/profiles/index') . '?' . http_build_query($content));
            }

            $this->filters = $content;
        }
    }


    public function fetchVariable($name)
    {
        if ((isset($this->filters[$name]) && ($this->filters[$name] !== ''))) {
            $return = (!is_array($this->filters[$name])) ? trim($this->filters[$name]) : $this->filters[$name];
        } else {
            $return = false;
        }

        return $return;
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->prepareFilter();

        $criteria = new CDbCriteria();
        $with = array();

        if (($status = $this->fetchVariable('status')) !== false) {
            $criteria->addInCondition('status', $status);
        }
        if ($lastName = $this->fetchVariable('last_name')) {
            $criteria->addSearchCondition('last_name', $lastName);
        }
        if ($firstName = $this->fetchVariable('first_name')) {
            $criteria->addSearchCondition('first_name', $firstName);
        }
        if (($gender = $this->fetchVariable('gender')) !== false) {
            $criteria->addCondition('gender = "' . $gender . '"');
        }
        if (($disability = $this->fetchVariable('disability')) !== false) {
            $criteria->addCondition('disability = "' . $disability . '"');
        }
        if (($ageMin = $this->fetchVariable('age_min')) !== false) {
            $criteria->addCondition("birth_date IS NULL OR ((birth_date IS NOT NULL) AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birth_date)), '%Y')+0) >= " . $ageMin . ")");
        }
        if (($ageMax = $this->fetchVariable('age_max')) !== false) {
            $criteria->addCondition("birth_date IS NULL OR ((birth_date IS NOT NULL) AND (DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birth_date)), '%Y')+0) <= " . $ageMax . ")");
        }
        if ($locations = $this->fetchVariable('locations')) {
            $with[] = 'citiesJobLocations';
            $criteria->addInCondition('citiesJobLocations_citiesJobLocations.city_id', $locations);
        }
        if ($residencies = $this->fetchVariable('residencies')) {
            $with[] = 'citiesResidence';
            $criteria->addInCondition('citiesResidence_citiesResidence.city_id', $residencies);
        }
        if ($categories = $this->fetchVariable('categories')) {
            $with[] = 'categories';
            $criteria->addInCondition('category_id', $categories);
        }
        if ($desiredPositions = $this->fetchVariable('desiredPositions')) {
            $with[] = 'desiredPositions';
            $criteria->addInCondition('desiredPositions_desiredPositions.position_id', $desiredPositions);
        }
        if ($positions = $this->fetchVariable('positions')) {
            $with[] = 'positions';
            $criteria->addInCondition('positions_positions.position_id', $positions);
        }
        if ($assistanceIds = $this->fetchVariable('assistanceIds')) {
            $with[] = 'assistanceTypes';
            $criteria->addInCondition('assistance_type_id', $assistanceIds);
        }

        /** Check if user group has access to ATO profiles
            IF ACCESS DENIED:
            Select only profiles where not in ATO profiles list
        */
       if((!Yii::app()->user->checkAccess(User::ROLE_VOLONT_ATO))) {
           //$with[] = 'applicantTypes';
           //$criteria->addCondition('applicant_type_id', [1]);
           $criteria->join = "JOIN ( SELECT DISTINCT id
                             FROM cv_list
                             WHERE id NOT IN
                             (
                             SELECT cv_id
                             FROM cv_to_applicant_type
                             WHERE applicant_type_id = 3
                             )
                             ) t2 ON t.id = t2.id";

          }

        if ($applicantTypeIds = $this->fetchVariable('applicantTypeIds')) {
            $with[] = 'applicantTypes';
            $criteria->addInCondition('applicant_type_id', $applicantTypeIds);
        }

        if ($licensesIds = $this->fetchVariable('licensesIds')) {
            $with[] = 'driverLicensesTypes';
            $criteria->addInCondition('license_id', $licensesIds);
        }
        if ($recruiterId = $this->fetchVariable('recruiter_id')) {
            $criteria->addCondition('recruiter_id = ' . $recruiterId);
        }
        if ($addedTimeFrom = $this->fetchVariable('added_time_from')) {
            $criteria->addCondition('t.added_time >= "' . date('Y-m-d 00:00:00', strtotime($addedTimeFrom)) . '"');
        }
        if ($addedTimeTo = $this->fetchVariable('added_time_to')) {
            $criteria->addCondition('t.added_time <= "' . date('Y-m-d 23:59:59', strtotime($addedTimeTo)) . '"');
        }
        if ($contactPhone = $this->fetchVariable('contact_phone')) {
            $criteria->addSearchCondition('contact_phone', $contactPhone);
        }
        if ($email = $this->fetchVariable('email')) {
            $criteria->addSearchCondition('email', $email);
        }

        if (($english = $this->fetchVariable('foreign_english')) !== false) {
            $criteria->addCondition('foreign_english = "' . $english . '"');
        }
        if (($germany = $this->fetchVariable('foreign_germany')) !== false) {
            $criteria->addCondition('foreign_germany = "' . $germany . '"');
        }
        if (($french = $this->fetchVariable('foreign_french')) !== false) {
            $criteria->addCondition('foreign_french = "' . $french . '"');
        }
        if (($china = $this->fetchVariable('foreign_china')) !== false) {
            $criteria->addCondition('foreign_china = "' . $china . '"');
        }

        if (($spain = $this->fetchVariable('foreign_spain')) !== false) {
            $criteria->addCondition('foreign_spain = "' . $spain . '"');
        }

        //Search only volunter models when have added status
        if (($onlyMy = $this->fetchVariable('only_my_comments')) !== false) {
            $criteria->join = 'INNER JOIN cv_statuses ON t.id = cv_statuses.cv_id';
            $criteria->addCondition('cv_statuses.operator_id = ' . Yii::app()->user->id);
            $criteria->distinct = true;
        }
        if (($meRecruiter = $this->fetchVariable('me_recruiter')) !== false) {
            $criteria->addCondition('t.recruiter_id = ' . Yii::app()->user->id);
        }



        if (!empty($with)) {
            $criteria->with = $with;
            $criteria->together = true;
        }

        $criteria->order = 'last_update DESC';

        $dataProvider = new CActiveDataProvider('CvList', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 20,
                    'pageVar' => 'page',
                ),
            )
        );

        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
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
     *
     * @param CvList $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cv-list-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function sendMail($title, $body, $sendTo, $id)
    {
        if ($sendTo) {
            $detailUrl = "http://czvl.org.ua/manage/profiles/view/id/{$id}";
            $message = Yii::app()->mailer
                ->createMessage("[ЦЗВЛ] {$title}", "{$body} \n Деталі: {$detailUrl}")
                ->setFrom(array('czvl-support@ukr.net' => 'Центр Зайнятості Вільних Людей'))
                ->setTo(array($sendTo, $sendTo));

            Yii::app()->mailer->send($message);
        }
    }


    public function actionExport()
    {
        if (sizeof($this->toExport)) {
            $rows = array();
            $items = CvList::model()->getItemsByList($this->toExport);
            foreach ($items as $item) {
                $export_item = new ExportItem();
                $export_item->id = $item->id;
                $export_item->first_name = $item->first_name;
                $export_item->last_name = $item->last_name;
                $export_item->contact_phone = $item->contact_phone;
                $export_item->email = $item->email;
                $export_item->other_contacts = $item->other_contacts;
                $export_item->desired_position = $item->desired_position;   // old textarea desired position field
                $export_item->desired_positions = implode(', ',
                    array_values(CHtml::listData($item->desiredPositions, 'id',
                        'name')));  // candidate's desired positions list
                $export_item->desired_place = implode(', ',
                    array_values(CHtml::listData($item->citiesJobLocations, 'city_index', 'city_name')));
                $export_item->residencies = implode(', ',
                    array_values(CHtml::listData($item->citiesResidence, 'city_index', 'city_name')));
                $export_item->education = $item->educationTypes[$item->education];
                $export_item->eduction_info = $item->eduction_info;
                $export_item->work_experience = $item->work_experience;
                $export_item->skills = $item->skills;
                $export_item->driver_licenses = implode(', ',
                    array_values(CHtml::listData($item->driverLicensesTypes, 'id', 'name')));
                $export_item->summary = $item->summary;
                $export_item->gender = $item->genderTypes[$item->gender];

                $export_item->marital_status = $item->maritalStatuses[$item->gender][(int)$item->marital_status];
                $export_item->birth_date = $item->birth_date;
                $export_item->documents = $item->documents;
                $export_item->assistance = $item->flat_assistances;
                $export_item->disability = $item->disabilityGroups[$item->disability];
                $export_item->applicant_types = implode(', ', array_values(CHtml::listData($item->applicantTypes, 'id',
                    'name')));  // candidate's desired positions list

                $rows[] = $export_item;
            }

            $this->toExcel($rows, array(
                'id',
                'first_name',
                'last_name',
                'contact_phone',
                'email',
                'other_contacts',
                'desired_position',
                'desired_positions',
                'desired_place',
                'residencies',
                'education',
                'eduction_info',
                'work_experience',
                'skills',
                'driver_licenses',
                'summary',
                'disability',
                'gender',
                'marital_status',
                'birth_date',
                'documents',
                'applicant_types',
                'assistance'
            ),
                'CZVL-profiles-export-' . date('Ymd-His'),
                array('creator' => 'PHP'),
                'Excel2007' // This is the default value, so you can omit it. You can export to CSV, PDF or HTML too
            );
        }
        throw new CHttpException(404, Yii::t('profile', 'Нічого експортувати'));
    }

}
