<?php


class CompanyHelper
{
    public static function userList($companyId)
    {
        $company = Company::model()->findByPk($companyId);
        if(!$company instanceof Company) {
            throw new ErrorException('Company not found');
        }
        $result = [];
        foreach($company->users as $user) {
            $result[$user->id] = $user->getFirstLastName()
            . " " . $user->position
            . " " . $user->phone
            ;
        }

        return $result;
    }
}