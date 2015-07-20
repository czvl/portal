<?php

class EmployerController extends Controller
{

    /**
     * @inheritdoc
     */
    public function filters()
    {
        return [
            'accessControl'
        ];
    }


    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'roles' => [User::ROLE_EMPL]
            ],
            [
                'deny',
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Vacancy();

        if (isset($_GET['Vacancy'])) {
            $model->attributes = $_GET['Vacancy'];
        }

        $company = $this->getCompany();

        $dataProvider = $model->search();
        $dataProvider->criteria->compare('company_id', $company->id);

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate_vacancy($id)
    {
        $company = $this->getCompany();

        $vacancy = Vacancy::model()->findByAttributes([
            'id' => $id,
            'company_id' => $company->id
        ]);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancy-form') {
            echo CActiveForm::validate($vacancy);
            Yii::app()->end();
        }

        if(!empty($_POST['Vacancy'])) {
            $vacancy->attributes = $_POST['Vacancy'];
            /* @var $vacancy ESaveRelatedBehavior */
            if($vacancy->saveWithRelated([
                'categories',
                'positions',
                'educations',
            ])){
                Yii::app()->user->setFlash('success', Yii::t('main', 'vacancy.saved.success'));
                $this->redirect($this->createUrl('index'));
            }
        }

        $this->render('update_vacancy', [
            'vacancy' => $vacancy,
            'company' => $company,
        ]);
    }

    public function actionCreate_vacancy()
    {
        $company = $this->getCompany();
        $vacancy = new Vacancy();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancy-form') {
            echo CActiveForm::validate($vacancy);
            Yii::app()->end();
        }

        if(!empty($_POST['Vacancy'])) {
            $vacancy->attributes = $_POST['Vacancy'];

            $vacancy->company_id = $company->id;
            $vacancy->user_id = Yii::app()->user->id;
            $vacancy->created_by = Yii::app()->user->id;

            /* @var $vacancy ESaveRelatedBehavior */
            if($vacancy->saveWithRelated([
                'categories',
                'positions',
                'educations',
            ])){

                Yii::app()->user->setFlash('success', Yii::t('main','vacancy.created.success'));
                $this->redirect($this->createUrl('index'));
            }
        }

        $this->render('create_vacancy', [
            'company' => $company,
            'vacancy' => $vacancy
        ]);
    }


    /**
     * @throws CException
     * @return Company
     */
    private function getCompany()
    {
        $user = $this->getUser();
        $companies = $user->companiesList;

        if(!is_array($companies) || count($companies) != 1) {
            throw new CException('Incorrect companies number');
        }

        return $companies[0];
    }

    /**
     * @return null|User
     *
     */
    private function getUser()
    {
        return User::model()->findByPk(Yii::app()->user->id);
    }
}