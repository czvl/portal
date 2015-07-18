<?php
/**
 * @var $this VacanciesController
 * @var $vacancy Vacancy
 * @var $company Company
 */
$this->renderPartial('/vacancies/_form', [
    'model' => $vacancy,
    'company' => $company,
]);