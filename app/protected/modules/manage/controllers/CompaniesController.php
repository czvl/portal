<?php

class CompaniesController extends Controller
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
                'actions' => array('view', 'index'),
                'roles' => [User::ROLE_VOLONT]
            ],

            [
				'allow',
				'actions' => array('create', 'update'),
				'roles'   => array('administrator', 'manager'),
			],

            [
                'allow',
                'actions' => array('delete'),
                'roles'   => array('adminisrator'),
            ],

            [
                'deny',
                'users' => ['*'],
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new Company();

        if (isset($_GET['Company'])) {
            $model->attributes = $_GET['Company'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $company = Company::model()->findByPk($id);
        if(!$company) {
            throw new CHttpException(404, 'Company not found');
        }

        $usersDataProvider = new CActiveDataProvider(User::class);
        $usersDataProvider->setData($company->users);
        $usersDataProvider->sort = false;


        $this->render('view', [
            'company' => $company,
            'usersDataProvider' => $usersDataProvider,
        ]);
    }

    public function actionDelete($id) {

        $company = Company::model()->findByPk($id);
        if(!$company) {
            throw new CHttpException(404, 'Company not found');
        }
        else {
            $company->delete();
            Vacancy::model()->deleteAll("company_id={$id}");
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, "Компанiя '{$company->name}' була видалена з бази!");
            $log = new Log();
			$log->action = "delete_company_{$id}_name_{$company->name}";
			$log->save();
            return $this->redirect('/manage/companies/index');
        }
    }

}