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

        $sql = "SELECT
                    ID,
                    DATE_FORMAT(post_date, '%d/%m/%Y') AS p_date,
                    post_title,
                    post_content,
                    guid
                FROM wp_posts
                WHERE post_status = 'publish'
                ORDER BY post_date DESC
                LIMIT 3";

        $blogArticles = Yii::app()->db->createCommand($sql)->queryAll();

        $publicKey = 'i67040413486';
        $privateKey = '2bBkcKXv67KddrAwaMFfBeZqefkGEWgZ1Sx1EeJF';
        $liqpayConfig = array(
            'version'        => '3',
            'amount'         => '100',
            'currency'       => 'UAH',
            'description'    => 'Підтримка проекту Центр Зайнятості Вільних Людей',
            'order_id'       => 'czvldonate' . date('ymdHi') . rand(100, 1000),
            'type'          => 'donate'
        );

        $liqpay = new LiqPay($publicKey, $privateKey);
        $liqpaySignature = $liqpay->cnb_signature($liqpayConfig);

        $liqpayConfig['signature'] = $liqpaySignature;
        $liqpayConfig['public_key'] = $publicKey;

        $this->render('index', array(
            'blog_articles' => $blogArticles,
            'liqpay' => $liqpayConfig
        ));
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

    public function actionApplicants()
    {
        $model = new CvList();
        $model->scenario = 'public';
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['CvList'])) {
            
            $model->attributes = $_POST['CvList'];
            
            $result = array();
            $t = false;
            
            if (!Yii::app()->db->currentTransaction) {
                $t = Yii::app()->db->beginTransaction();
            }
            
            if ($model->save()) {
                if (!empty($_POST['CvList']['residenciesIds'])) {
                    foreach($_POST['CvList']['residenciesIds'] as $r) {
                        $residence = new CvToResidence();
                        $residence->cv_id = $model->id;
                        $residence->city_id = $r;
                        if (!$residence->save()) {
                            $result[] = false;
                        }
                    }
                }

                if (!empty($_POST['CvList']['driverLicensesIds'])) {
                    foreach ($_POST['CvList']['driverLicensesIds'] as $dl) {
                        $license = new CvToDriverLicense();
                        $license->cv_id = $model->id;
                        $license->license_id = $dl;
                        if (!$license->save()) {
                            $result[] = false;
                        }
                    }
                }
                
                if (!empty($_POST['CvList']['jobLocationsIds'])) {
                    foreach ($_POST['CvList']['jobLocationsIds'] as $jl) {
                        $jobLocation = new CvToJobLocation();
                        $jobLocation->cv_id = $model->id;
                        $jobLocation->city_id = $jl;
                        if (!$jobLocation->save()) {
                            $result[] = false;
                        }
                    }
                }
                
                if (!empty($_POST['CvList']['assistanceIds'])) {
                    foreach ($_POST['CvList']['assistanceIds'] as $ai) {
                        $assistance = new CvToAssistance();
                        $assistance->cv_id = $model->id;
                        $assistance->assistance_type_id = $ai;
                        if (!$assistance->save()) {
                            $result[] = false;
                        }
                    }
                }
                
            } else {
                $result[] = false;
            }
            
            if ($t && !in_array(false, $result)) {
                $t->commit();
                $this->redirect(array('applicants', 'success' => true));
            } else {
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
    protected function getThumb($postId)
    {
        $sql = "SELECT
                    post_parent,
                    guid
                FROM wp_posts
                WHERE ID = (
                      SELECT meta_value
                      FROM wp_postmeta
                      WHERE post_id = " . $postId . "
                        AND meta_key = '_thumbnail_id'
                )";

        $imagePath = Yii::app()->db->createCommand($sql)->queryRow();

        if ($imagePath) {
            $path = substr($imagePath['guid'], 0, -4);
            $ext = substr($imagePath['guid'], -4);
            $imagePath = $path .  "-300x200" . $ext;
            return $imagePath;
        } else {
            return "/blog/wp-content/themes/point/images/mediumthumb.png";
        }
    }
}
