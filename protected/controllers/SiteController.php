<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
//            'captcha' => array(
//                'class' => 'CCaptchaAction',
//                'backColor' => 0xFFFFFF,
//            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
//    public function actionContact()
//    {
//        $model = new ContactForm;
//        if (isset($_POST['ContactForm'])) {
//            $model->attributes = $_POST['ContactForm'];
//            if ($model->validate()) {
//                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
//                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
//                $headers = "From: $name <{$model->email}>\r\n" .
//                        "Reply-To: {$model->email}\r\n" .
//                        "MIME-Version: 1.0\r\n" .
//                        "Content-Type: text/plain; charset=UTF-8";
//
//                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
//                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
//                $this->refresh();
//            }
//        }
//        $this->render('contact', array('model' => $model));
//    }

    public function actionApplicants()
    {
        $model = new CvList();
        $model->scenario = 'public';
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['CvList'])) {
            
            $model->attributes = $_POST['CvList'];
            $result = true;
            $t = false;
            
            if (!Yii::app()->db->currentTransaction) {
                $t = Yii::app()->db->beginTransaction();
            }
            
            if (!$model->save()) {
                $result = false;
            }
            $result = false;
            echo $model->id;
            
            if (!empty($_POST['CvList']['residenciesIds'])) {
                echo "<p>Residence: ";
                foreach($_POST['CvList']['residenciesIds'] as $r) {
                    echo $r . ",";
                }
                echo "</p>";
            }
            
            if (!empty($_POST['CvList']['driverLicensesIds'])) {
                echo "<p>Driver license: ";
                foreach ($_POST['CvList']['driverLicensesIds'] as $dl) {
                    echo $dl . ",";
                }
                echo "</p>";
            }
            if (!empty($_POST['CvList']['jobLocationsIds'])) {
                echo "<p>Job locations: ";
                foreach ($_POST['CvList']['jobLocationsIds'] as $jl) {
                    echo $jl . ",";
                }
                echo "</p>";
            }
            if (!empty($_POST['CvList']['assistanceIds'])) {
                echo "<p>Assistance: ";
                foreach ($_POST['CvList']['assistanceIds'] as $ai) {
                    echo $ai . ",";
                }
                echo "</p>";
            }

            if ($t && $result) {
                $t->commit();
                $this->redirect(array('applicants', array('success' => true)));
            }
            if ($t && !$result) {
                $t->rollback();
            }
        }

        $this->render('applicants', array('model' => $model));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cv-list-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
