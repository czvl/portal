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
            . ' <' . $user->email . '>';
        $subject = Yii::t('main', 'user.email.confirm.subject');

        mail($to, $subject, $body, "From: CZVL.ORG.UA <service@dev.czvl.org.ua>\r\n");

        return true;

    }
}