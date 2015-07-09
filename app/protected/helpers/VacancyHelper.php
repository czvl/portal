<?php

class VacancyHelper
{

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