<?php
/**
 * @var $this VacanciesController
 * @var $company Company
 * @var $vacancy Vacancy
 */

?>
    <h1>Создание вакансии для <?= CHtml::encode($company->name) ?></h1>
<?php

$this->renderPartial('_form', [
    'model' => $vacancy,
    'company' => $company,
]);