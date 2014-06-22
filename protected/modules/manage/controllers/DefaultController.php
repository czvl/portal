<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionLogin()
    {   
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                //$this->redirect(Yii::app()->user->returnUrl);
                $this->redirect(array('/manage/'));
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }
    
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('/manage/login'));
    }
//    public function actionLogin2()
//    {
//        $serviceName = Yii::app()->request->getQuery('service');
//        if (isset($serviceName)) {
//            /** @var $eauth EAuthServiceBase */
//            $eauth = Yii::app()->eauth->getIdentity($serviceName);
//            $eauth->redirectUrl = Yii::app()->user->returnUrl;
//            $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');
//
//            try {
//                if ($eauth->authenticate()) {
//                    $identity = new EAuthUserIdentity($eauth);
//
//                    // var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
//                    // successful authentication
//                    if ($identity->authenticate()) {
//                        Yii::app()->user->login($identity);
//                        //var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;
//                        // Save the attributes to display it in layouts/main.php
//                        $session = Yii::app()->session;
//                        $session['eauth_profile'] = $eauth->attributes;
//
//                        // redirect and close the popup window if needed
//                        $eauth->redirect();
//                    } else {
//                        // close popup window and redirect to cancelUrl
//                        $eauth->cancel();
//                    }
//                }
//
//                // Something went wrong, redirect back to login page
//                $this->redirect(array('site/login'));
//            } catch (EAuthException $e) {
//                // save authentication error to session
//                Yii::app()->user->setFlash('error', 'EAuthException: ' . $e->getMessage());
//
//                // close popup window and redirect to cancelUrl
//                $eauth->redirect($eauth->getCancelUrl());
//            }
//        }
//    }

}
