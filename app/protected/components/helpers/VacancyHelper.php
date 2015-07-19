<?php

class VacancyHelper
{

    /**
     * Vacancy statuses
     * @return array
     */
    public static function statuses()
    {
        return [
            Vacancy::STATUS_OPEN => Yii::t('main', 'vacancy.status.open'),
            Vacancy::STATUS_CLOSED => Yii::t('main', 'vacancy.status.closed'),
        ];
    }

    /**
     * Vacancy category names
     * @param Vacancy $vacancy
     * @return array
     */
    public static function categories(Vacancy $vacancy)
    {
        $result = [];
        foreach($vacancy->categories as $category) {
            $result[] = $category->name;
        }

        return $result;
    }

    /**
     * Comma separated Vacancy category names
     * @param Vacancy $vacancy
     * @return string
     */
    public static function  categoriesAsString(Vacancy $vacancy)
    {
        return implode(", ", self::categories($vacancy));
    }

    /**
     * Name of vacancy status
     * @param Vacancy $vacancy
     * @return string
     */
    public static function statusName(Vacancy $vacancy)
    {
        $statuses = self::statuses();

        return isset($statuses[$vacancy->status])
            ? $statuses[$vacancy->status]
            : 'incorrect status';
    }

    /**
     * Vacancy positions
     * @param Vacancy $vacancy
     * @return array
     */
    public static function positions(Vacancy $vacancy)
    {
        $result = [];
        foreach ($vacancy->positions as $position) {
            $result[] = $position->name;
        }

        return $result;
    }

    /**
     * Comma separated vacancy position names
     * @param Vacancy $vacancy
     * @return string
     */
    public static function positionsAsString(Vacancy $vacancy)
    {
        return implode(", ", self::positions($vacancy));
    }

    /**
     * Vacancy educations
     * @param Vacancy $vacancy
     * @return array
     */
    public static function educations(Vacancy $vacancy)
    {
        $result = [];
        foreach ($vacancy->educations as $education) {
            $result[] = $education->name;
        }

        return $result;
    }

    /**
     * Comma separated vacancy education names
     * @param Vacancy $vacancy
     * @return string
     */
    public static function educationsAsString(Vacancy $vacancy)
    {
        return implode(", ", self::educations($vacancy));
    }

}