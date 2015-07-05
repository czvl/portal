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

                $this->deleteAllCategories($id);
                $categoriesAttrName = VacancyCategoriesHelper::fieldName();
                if(isset($_POST[$categoriesAttrName]) && is_array($_POST[$categoriesAttrName])) {
                    $this->setCategories($id, $_POST[$categoriesAttrName]);
                }

                $this->deleteAllEducations($id);
                $educationsAttrName = EducationHelper::fieldName();
                if(isset($_POST[$educationsAttrName]) && is_array($_POST[$educationsAttrName])) {
                    $this->setEducations($id, $_POST[$educationsAttrName]);
                }

                $this->deleteAllPositions($id);
                $positionAttrName = PositionsHelper::fieldName();
                if(isset($_POST[$positionAttrName]) && is_array($_POST[$positionAttrName])) {
                    $this->setPositions($id, $_POST[$positionAttrName]);
                }

                Yii::app()->user->setFlash('success', 'vacancy.saved.success');
                $this->redirect($this->createUrl('vacancies/index'));
            }
        }

        $this->render('update', [
            'vacancy' => $vacancy,
            'company' => $vacancy->company,
        ]);
    }

    private function setCategories($vacancyId, array $categories)
    {
        foreach($categories as $categoryId) {
            $vacancyToCategory = new VacancyToCategory();
            $vacancyToCategory->vacancy_id = $vacancyId;
            $vacancyToCategory->category_id = $categoryId;
            $vacancyToCategory->save();
        }
    }

    private function setPositions($vacancyId, array $positions)
    {
        foreach($positions as $positionId) {
            $vacancyToPosition = new VacancyToPosition();
            $vacancyToPosition->vacancy_id = $vacancyId;
            $vacancyToPosition->position_id = $positionId;
            $vacancyToPosition->save();
        }
    }

    private function setEducations($vacancyId, array $educations)
    {
        foreach($educations as $educationId) {
            $vacancyToCategory = new VacancyToEducation();
            $vacancyToCategory->vacancy_id = $vacancyId;
            $vacancyToCategory->education_id = $educationId;
            $vacancyToCategory->save();
        }
    }

    private function deleteAllCategories($vacancyId)
    {
        VacancyToCategory::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
        ]);
    }

    private function deleteAllEducations($vacancyId)
    {
        VacancyToEducation::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
        ]);
    }

    private function deleteAllPositions($vacancyId)
    {
        VacancyToPosition::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
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
            echo CActiveForm::validate($company);
            Yii::app()->end();
        }

        if(!empty($_POST['Vacancy'])) {
            $vacancy->attributes = $_POST['Vacancy'];
            $vacancy->company_id = $id;
            $vacancy->status = Vacancy::STATUS_OPEN;

            if($vacancy->save()){

                $categoriesAttrName = VacancyCategoriesHelper::fieldName();
                if(isset($_POST[$categoriesAttrName]) && is_array($_POST[$categoriesAttrName])) {
                    $this->setCategories($vacancy->id, $_POST[$categoriesAttrName]);
                }

                $educationsAttrName = EducationHelper::fieldName();
                if(isset($_POST[$educationsAttrName]) && is_array($_POST[$educationsAttrName])) {
                    $this->setEducations($id, $_POST[$educationsAttrName]);
                }

                $positionAttrName = PositionsHelper::fieldName();
                if(isset($_POST[$positionAttrName]) && is_array($_POST[$positionAttrName])) {
                    $this->setPositions($id, $_POST[$positionAttrName]);
                }

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