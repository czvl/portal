<?php
/**
 * @var $this VacanciesController
 * @var $vacancy Vacancy
 * @var $company Company
 */
$this->renderPartial('_form', [
    'model' => $vacancy,
    'company' => $company,
]);