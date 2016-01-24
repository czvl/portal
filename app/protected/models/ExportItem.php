<?php

class ExportItem extends CModel {

    public $id;
    public $first_name;
    public $last_name;
    public $contact_phone;
    public $email;
    public $other_contacts;
    public $desired_position;
    public $desired_place;
    public $residencies;
    public $education;
    public $eduction_info;
    public $work_experience;
    public $skills;
    public $driver_licenses;
    public $summary;
    public $gender;
    public $marital_status;
    public $birth_date;
    public $documents;
    public $assistance;
    public $disability;


    public function attributeNames() {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => 'Ім’я',
            'last_name' => 'Прізвище',
            'contact_phone' => 'Телефон',
            'email' => 'Електронна пошта',
            'other_contacts' => 'Інші контакти',
            'desired_position' => 'Бажана посада',
            'desired_place' => 'Бажане місто роботи',
            'residencies' => 'Місто проживання, знаходження',
            'education' => 'Освіта',
            'eduction_info' => 'Про освіту',
            'work_experience' => 'Досвід роботи',
            'skills' => 'Навички',
            'driver_licenses' => 'Водійські права',
            'summary' => 'Про себе',
            'gender' => 'Стать',
            'marital_status' => 'Сімейний стан',
            'birth_date' => 'Дата народження',
            'documents' => 'Наявні документи',
            'assistance' => 'Потрібна допомога',
            'disability' => 'Наявність інвалідності',
        );
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, first_name, last_name, contact_phone, email, other_contacts, desired_position, desired_place, residencies, education, eduction_info, work_experience, skills, driver_licenses, summary, gender, marital_status, birth_date, documents, assistance, disability', 'safe'),
        );
    }
}
