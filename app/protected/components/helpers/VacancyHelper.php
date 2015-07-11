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

    /**
     * Saves categories, educations and similar positions for vacancy
     * @param $vacancyId
     * @param $data
     */
    public static function saveAdditionalFields($vacancyId, $data)
    {
        self::deleteAllCategories($vacancyId);
        $categoriesAttrName = VacancyCategoriesHelper::fieldName();
        if(isset($data[$categoriesAttrName]) && is_array($data[$categoriesAttrName])) {
            self::setCategories($vacancyId, $data[$categoriesAttrName]);
        }

        self::deleteAllEducations($vacancyId);
        $educationsAttrName = EducationHelper::fieldName();
        if(isset($data[$educationsAttrName]) && is_array($data[$educationsAttrName])) {
            self::setEducations($vacancyId, $data[$educationsAttrName]);
        }

        self::deleteAllPositions($vacancyId);
        $positionAttrName = PositionsHelper::fieldName();
        if(isset($data[$positionAttrName]) && is_array($data[$positionAttrName])) {
            self::setPositions($vacancyId, $data[$positionAttrName]);
        }
    }

    private static function setCategories($vacancyId, array $categories)
    {
        foreach ($categories as $categoryId) {
            $vacancyToCategory = new VacancyToCategory();
            $vacancyToCategory->vacancy_id = $vacancyId;
            $vacancyToCategory->category_id = $categoryId;
            $vacancyToCategory->save();
        }
    }

    private static function setPositions($vacancyId, array $positions)
    {
        foreach ($positions as $positionId) {
            $vacancyToPosition = new VacancyToPosition();
            $vacancyToPosition->vacancy_id = $vacancyId;
            $vacancyToPosition->position_id = $positionId;
            $vacancyToPosition->save();
        }
    }

    private static function setEducations($vacancyId, array $educations)
    {
        foreach ($educations as $educationId) {
            $vacancyToCategory = new VacancyToEducation();
            $vacancyToCategory->vacancy_id = $vacancyId;
            $vacancyToCategory->education_id = $educationId;
            $vacancyToCategory->save();
        }
    }

    private static function deleteAllCategories($vacancyId)
    {
        VacancyToCategory::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
        ]);
    }

    private static function deleteAllEducations($vacancyId)
    {
        VacancyToEducation::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
        ]);
    }

    private static function deleteAllPositions($vacancyId)
    {
        VacancyToPosition::model()->deleteAll('vacancy_id=:vacancy_id', [
            ':vacancy_id' => $vacancyId,
        ]);
    }
}