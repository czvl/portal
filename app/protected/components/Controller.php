<?php

class Controller extends CController
{
    public $menu = array();
    public $breadcrumbs = array();
    
    public function getTimeDiff($date)
    {
        $date = new DateTime($date);
        $now = new DateTime();
        $interval = $now->diff($date);
        
        if ($interval->y != 0) {
            return Yii::t('profile', 'years', $interval->y);
        } else if ($interval->m != 0) {
            return Yii::t('profile', 'months', $interval->m) . "  " . Yii::t('profile', 'days', $interval->d);
        } else if ($interval->d != 0) {
            return Yii::t('profile', 'days', $interval->d);
        } else if ($interval->h != 0) {
            return Yii::t('profile', 'hours', $interval->h);
        } else if ($interval->i != 0) {
            return Yii::t('profile', 'minutes', $interval->i);
        } else {
            return Yii::t('profile', 'lessthanminute');
        }
    }
    
    public function getVariable($name)
    {
        if ((isset($_GET[$name]) && ($_GET[$name] !== ''))) {
            $return = (!is_array($_GET[$name])) ? trim($_GET[$name]) : $_GET[$name];
        } else {
            $return = false;
        }
        return $return;
    }

}
