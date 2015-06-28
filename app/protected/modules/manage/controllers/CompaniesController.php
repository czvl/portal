<?php

class CompaniesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['index'],
                'roles' => [User::ROLE_MANAGER, User::ROLE_ADMIN]
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

}