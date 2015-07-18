<?php
/**
 * @var $this VacanciesController
 * @var $company Company
 * @var $vacancy Vacancy
 */

$this->renderPartial('_form', [
    'model' => $vacancy,
    'company' => $company,
]);