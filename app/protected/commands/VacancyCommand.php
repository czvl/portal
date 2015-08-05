<?php

class VacancyCommand extends CConsoleCommand
{
    /**
     * Finds and deactivates out of date  vacancies
     */
    public function actionDeactivate()
    {
        echo "Start.." . PHP_EOL;
        $vacancies = Vacancy::model()->findAll(
            'status=:status AND close_time < :close_time'            ,
            [
                ':status' => Vacancy::STATUS_OPEN,
                ':close_time' => date("Y-m-d H:i:s", time())
            ]
        );

        foreach($vacancies as $vacancy) { /* @var $vacancy Vacancy */
            echo $vacancy->id . PHP_EOL;
            $this->deactivateVacancy($vacancy);
            $this->sendMessage($vacancy);
        }
    }

    /**
     * @param Vacancy $vacancy
     */
    private function deactivateVacancy(Vacancy $vacancy)
    {
        $vacancy->status = Vacancy::STATUS_CLOSED;
        $vacancy->updated_by = 0;
        $vacancy->hash = md5(microtime(true). $vacancy->user_id);

        $vacancy->save(false);
    }

    /**
     * @param Vacancy $vacancy
     * @return bool
     */
    private function sendMessage(Vacancy $vacancy)
    {
        $user = $vacancy->user;
        if(is_null($user)) {
            return false;
        }

        $body = Yii::t('main', 'vacancy.email.deactivate.body', [
            ':name' => $vacancy->name,
            ':days' => Vacancy::INTERVAL_OPENED,
            ':link' => Yii::app()->urlManager->createUrl('/manage/employer/activate_vacancy', [
                'hash' => $vacancy->hash
            ]),
        ]);

        $subject = Yii::t('main', 'vacancy.email.deactivate.subject', [
            ':name' => $vacancy->name,
        ]);

        $message = Yii::app()->mailer
            ->createMessage($subject, $body)
            ->setFrom([Yii::app()->mailer->username => 'ЦЗВЛ'])
            ->setTo([$user->email => $user->first_name]);

        if(Yii::app()->mailer->send($message)) {
            return true;
        }

        return false;
    }
}