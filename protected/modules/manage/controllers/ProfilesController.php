<?php

class ProfilesController extends Controller {

	public $toExport = [];
	protected $filters = [];

	/**
	 * @return array action filters
	 */
	public function filters() {
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
	public function accessRules() {
		return array(
			array(
				'allow',
				'actions' => array('index', 'view', 'create', 'update', 'export'),
				'users'   => array('@'),
			),
			array(
				'allow',
				'actions' => array('delete'),
				'roles'   => array('administrator', 'manager'),
			),
			array(
				'deny',
				'users' => array('*'),
			),
		);
	}


	public function behaviors() {
		return array(
			'eexcelview' => array(
				'class' => 'ext.eexcelview.EExcelBehavior',
			),
		);
	}


	public function init() {
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
	public function actionView($id) {
		$model  = $this->loadModel($id);
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

				$log         = new Log();
				$log->action = 'add_status_to_user_' . $id;
				$log->save();

				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Ваш статус був доданий!');
				$this->redirect(array('/manage/profiles/view/', 'id' => $id, '#' => 'statuses'));
			}
		}

		if (isset($_POST['CvList'])) {
			$model->status = $_POST['CvList']['status'];
			if ($model->save()) {

				$log         = new Log();
				$log->action = 'change_status_to_user_' . $id . "_to_" . $_POST['CvList']['status'];
				$log->save();

				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, 'Статус анкети був оновлений!');
				$this->redirect(array('/manage/profiles/view/', 'id' => $id));
			}
		}

		$statuses = CvStatuses::model()->findAll(array(
			'condition' => 'cv_id=:cv_id',
			'params'    => array(':cv_id' => $id),
			'order'     => 'added_time DESC'
		));

		$this->render('view', array(
			'model'    => $model,
			'status'   => $status,
			'statuses' => $statuses
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new CvList();

		$this->performAjaxValidation($model);

		if (isset($_POST['CvList'])) {

			$model->attributes = $_POST['CvList'];

			$result = array();
			$t      = false;

			if (!Yii::app()->db->currentTransaction) {
				$t = Yii::app()->db->beginTransaction();
			}

			if ($model->save()) {
				if (!empty($_POST['CvList']['residenciesIds'])) {
//                    CvToResidence::model()->deleteAllByAttributes(array('cv_id' => $model->id));
					foreach ($_POST['CvList']['residenciesIds'] as $r) {
						$residence          = new CvToResidence();
						$residence->cv_id   = $model->id;
						$residence->city_id = $r;
						if (!$residence->save()) {
							$result[] = false;
						}
					}
				}

				if (!empty($_POST['CvList']['driverLicensesIds'])) {
//                    CvToDriverLicense::model()->deleteAllByAttributes(array('cv_id' => $model->id));
					foreach ($_POST['CvList']['driverLicensesIds'] as $dl) {
						$license             = new CvToDriverLicense();
						$license->cv_id      = $model->id;
						$license->license_id = $dl;
						if (!$license->save()) {
							$result[] = false;
						}
					}
				}

				if (!empty($_POST['CvList']['jobLocationsIds'])) {
//                    CvToJobLocation::model()->deleteAllByAttributes(array('cv_id' => $model->id));
					foreach ($_POST['CvList']['jobLocationsIds'] as $jl) {
						$jobLocation          = new CvToJobLocation();
						$jobLocation->cv_id   = $model->id;
						$jobLocation->city_id = $jl;
						if (!$jobLocation->save()) {
							$result[] = false;
						}
					}
				}

				if (!empty($_POST['CvList']['assistanceIds'])) {
//                    CvToAssistance::model()->deleteAllByAttributes(array('cv_id' => $model->id));
					foreach ($_POST['CvList']['assistanceIds'] as $ai) {
						$assistance                     = new CvToAssistance();
						$assistance->cv_id              = $model->id;
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

				$log         = new Log();
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		$this->performAjaxValidation($model);

		if (isset($_POST['CvList'])) {
			$model->attributes          = $_POST['CvList'];
			$model->categories          = $_POST['CvList']['categoryIds'];
			$model->positions           = $_POST['CvList']['positionsIds'];
			$model->citiesResidence     = $_POST['CvList']['residenciesIds'];
			$model->driverLicensesTypes = $_POST['CvList']['driverLicensesIds'];
			$model->citiesJobLocations  = $_POST['CvList']['jobLocationsIds'];
			$model->assistanceTypes     = $_POST['CvList']['assistanceIds'];
			if ($model->saveWithRelated(array(
				'categories',
				'positions',
				'citiesResidence',
				'citiesJobLocations',
				'driverLicensesTypes',
				'assistanceTypes'
			))
			) {

				$log         = new Log();
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
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {

			$model            = $this->loadModel($id);
			$model->is_active = 'no';
			$model->save(false);

//            CvStatuses::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToAssistance::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToCategory::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToDriverLicense::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToJobLocation::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToPosition::model()->deleteAllByAttributes(array('cv_id' => $id));
//            CvToResidence::model()->deleteAllByAttributes(array('cv_id' => $id));

			$log         = new Log();
			$log->action = "delete_user_" . $id;
			$log->save();

//            $this->loadModel($id)->delete();

			$this->redirect(array('index'));
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}


	protected function removeMark() {
		unset($_GET['post']);

		return $_GET;
	}


	protected function prepareFilter() {
		if (isset($_GET['post'])) {
			$get           = $this->removeMark();
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


	public function fetchVariable($name) {
		if ((isset($this->filters[ $name ]) && ($this->filters[ $name ] !== ''))) {
			$return = (!is_array($this->filters[ $name ])) ? trim($this->filters[ $name ]) : $this->filters[ $name ];
		} else {
			$return = false;
		}

		return $return;
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex() {

		$this->prepareFilter();

		$criteria = new CDbCriteria();
		$with     = array();

		if (($status = $this->fetchVariable('status')) !== false) {
			$criteria->condition = 'status = :status';
			$criteria->params    = array(':status' => $status);
		}
		if ($lastName = $this->fetchVariable('last_name')) {
			$criteria->addSearchCondition('last_name', $lastName);
		}
		if ($firstName = $this->fetchVariable('first_name')) {
			$criteria->addSearchCondition('first_name', $firstName);
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
		if ($positions = $this->fetchVariable('positions')) {
			$with[] = 'positions';
			$criteria->addInCondition('position_id', $positions);
		}
		if ($assistanceIds = $this->fetchVariable('assistanceIds')) {
			$with[] = 'assistanceTypes';
			$criteria->addInCondition('assistance_type_id', $assistanceIds);
		}
		if ($licensesIds = $this->fetchVariable('licensesIds')) {
			$with[] = 'driverLicensesTypes';
			$criteria->addInCondition('license_id', $licensesIds);
		}
		if ($recruiterId = $this->fetchVariable('recruiter_id')) {
			$criteria->condition = 'recruiter_id = :recruiter_id';
			$criteria->params    = array(':recruiter_id' => $recruiterId);
		}
		if ($internalNum = $this->fetchVariable('internal_num')) {
			$criteria->condition = 'internal_num = :internal_num';
			$criteria->params    = array(':internal_num' => $internalNum);
		}
		if ($contactPhone = $this->fetchVariable('contact_phone')) {
			$criteria->addSearchCondition('contact_phone', $contactPhone);
		}
		if ($email = $this->fetchVariable('email')) {
			$criteria->addSearchCondition('email', $email);
		}


		if (!empty($with)) {
			$criteria->with     = $with;
			$criteria->together = true;
		}

		/*
		if (!sizeof($this->filters)) {
			$criteria->condition = 'status = :status';
			$criteria->params = array(':status' => 0);
		}
		*/

		$criteria->order = 'last_update DESC';

		$dataProvider = new CActiveDataProvider('CvList', array(
				'criteria'   => $criteria,
				'pagination' => array(
					'pageSize' => 20,
					'pageVar'  => 'page',
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
	public function loadModel($id) {
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
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'cv-list-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionExport() {
		if (sizeof($this->toExport)) {
			$rows  = array();
			$items = CvList::model()->getItemsByList($this->toExport);
			foreach ($items as $item) {
				$export_item                   = new ExportItem();
				$export_item->id               = $item->id;
				$export_item->first_name       = $item->first_name;
				$export_item->last_name        = $item->last_name;
				$export_item->contact_phone    = $item->contact_phone;
				$export_item->email            = $item->email;
				$export_item->other_contacts   = $item->other_contacts;
				$export_item->desired_position = $item->desired_position;
				$export_item->desired_place    = implode(', ', array_values(CHtml::listData($item->citiesJobLocations, 'city_index', 'city_name')));
				$export_item->residencies      = implode(', ', array_values(CHtml::listData($item->citiesResidence, 'city_index', 'city_name')));
				$export_item->education        = $item->educationTypes[ $item->education ];
				$export_item->eduction_info    = $item->eduction_info;
				$export_item->work_experience  = $item->work_experience;
				$export_item->skills           = $item->skills;
				$export_item->driver_licenses  = implode(', ', array_values(CHtml::listData($item->driverLicensesTypes, 'id', 'name')));
				$export_item->summary          = $item->summary;
				$export_item->gender           = $item->genderTypes[ $item->gender ];
				$export_item->marital_status   = $item->maritalStatuses[ $item->gender ][ (int) $item->marital_status ];
				$export_item->birth_date       = $item->birth_date;
				$export_item->documents        = $item->documents;
				$export_item->assistance       = $item->flat_assistances;
				$rows[]                        = $export_item;
			}

			$this->toExcel($rows, array(
				'id',
				'first_name',
				'last_name',
				'contact_phone',
				'email',
				'other_contacts',
				'desired_position',
				'desired_place',
				'residencies',
				'education',
				'eduction_info',
				'work_experience',
				'skills',
				'driver_licenses',
				'summary',
				'gender',
				'marital_status',
				'birth_date',
				'documents',
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
