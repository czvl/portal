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
                'roles' => [User::ROLE_VOLONT]
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

}