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

}