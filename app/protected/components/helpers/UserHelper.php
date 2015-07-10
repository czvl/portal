<?php

class UserHelper
{
    const PHONE_MASK = '+38 (999) 999-99-99';

    public static function sendEmailConfirmation(User $user)
    {
        if (empty($user->hash) || !empty($user->email_activated)) {
            return false;
        }

        $body = Yii::t('main', 'user.email.confirm.body', [
            ':link' => Yii::app()->createAbsoluteUrl('/site/confirm_email', [
                'hash' => $user->hash
            ]),
        ]);
        $to = $user->first_name
            . ' ' . $user->last_name
            . ' <' . $user->email . '>';
        $subject = Yii::t('main', 'user.email.confirm.subject');

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf8\r\n";
        $headers .= "From: CZVL.ORG.UA <noreply@czvl.org.ua>\r\n";

        mail($to, $subject, $body, $headers);

        return true;

    }
}