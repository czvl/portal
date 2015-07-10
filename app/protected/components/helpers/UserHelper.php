<?php

class UserHelper
{
    const PHONE_MASK = '+38 (999) 999-99-99';

    public static function sendEmailConfirmation(User $user)
    {
        if(empty($user->hash) || !empty($user->email_activated)) {
            return false;
        }

        $message = new YiiMailMessage;
        $message->setBody(Yii::t('main', 'user.email.confirm.body', [
            ':link' => Yii::app()->createAbsoluteUrl('/site/confirm_email', [
                'hash' => $user->hash
            ]),
        ]), 'text/html');
        $message->subject = Yii::t('main', 'user.email.confirm.subject');
        $message->addTo($user->email);
        $message->from = Yii::app()->params['noreply@czvl.org.ua'];
        Yii::app()->mail->send($message);

        return true;

    }
}