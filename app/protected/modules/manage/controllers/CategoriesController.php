<?php

class CategoriesController extends Controller
{

    /**
     * @inheritdoc
     */
    public function filters()
    {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles' => array(User::ROLE_MANAGER),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $category = new CvCategories('search');
        if (isset($_GET['CvCategories'])) {
            $category->attributes = $_GET['CvCategories'];
        }

        return $this->render('index', [
            'model' => $category
        ]);
    }

}