<?php

class VacanciesController extends Controller
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
        $this->render('index');
    }

}