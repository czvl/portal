<?php

class VacanciesController extends Controller
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
                'roles' => [User::ROLE_VOLONT]
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

        $dataProvider = $model->search();

        $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $vacancy = Vacancy::model()->findByPk($id);
        if(empty($vacancy)) {
            throw new CHttpException(404, 'Vacancy not found');
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancy-form') {
            echo CActiveForm::validate($vacancy);
            Yii::app()->end();
        }

        if(!empty($_POST['Vacancy'])) {
            $vacancy->attributes = $_POST['Vacancy'];
            if($vacancy->save()){

                VacancyHelper::saveAdditionalFields($id, $_POST);

                Yii::app()->user->setFlash('success', 'vacancy.saved.success');
                $this->redirect($this->createUrl('vacancies/index'));
            }
        }

        $this->render('update', [
            'vacancy' => $vacancy,
            'company' => $vacancy->company,
        ]);
    }

    public function actionCreate($id)
    {
        $company = Company::model()->findByPk($id);
        $vacancy = new Vacancy();

        if(!$company) {
            throw new CHttpException(404, 'Company not found');
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancy-form') {
            echo CActiveForm::validate($vacancy);
            Yii::app()->end();
        }

        if(!empty($_POST['Vacancy'])) {
            $vacancy->attributes = $_POST['Vacancy'];
            $vacancy->company_id = $id;
            $vacancy->status = Vacancy::STATUS_OPEN;

            if($vacancy->save()){

                VacancyHelper::saveAdditionalFields($id, $_POST);

                Yii::app()->user->setFlash('success', 'vacancy.created.success');
                $this->redirect($this->createUrl('vacancies/index'));
            }
        }

        $this->render('create', [
            'company' => $company,
            'vacancy' => $vacancy
        ]);
    }

}