<?php

class CompanyController extends Controller
{

    public function actionIndex()
    {
        $this->render('index', [
            'company' => $this->getCompany(),
        ]);
    }

    /**
     * @return mixed
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