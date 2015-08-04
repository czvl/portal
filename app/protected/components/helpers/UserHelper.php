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
        $subject = Yii::t('main', 'user.email.confirm.subject');
        $message = Yii::app()->mailer
            ->createMessage($subject, $body)
            ->setFrom(['noreply@czvl.org.ua' => 'Центр зайнятості вільних людей'])
            ->setTo([$user->email => $user->first_name]);

        Yii::app()->mailer->send($message);

        return true;
    }
}