<?php

/**
 * This is the model class for table "cv_list".
 *
 * The followings are the available columns in table 'cv_list':
 * @property integer $id
 * @property integer $category_id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $birth_date
 * @property string $contact_phone
 * @property string $email
 * @property integer $education
 * @property string $eduction_info
 * @property string $work_experience
 * @property string $skills
 * @property string $summary
 * @property string $desired_position
 * @property string $documents
 * @property string $applicant_type
 * @property string $cv_file
 * @property integer $recruiter_id
 * @property string $recruiter_comments
 * @property string $who_filled
 * @property string $added_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Users $recruiter
 * @property CvCategories $category
 * @property CvStatuses[] $cvStatuses
 * @property AssistanceTypes[] $assistanceTypes
 * @property CitiesList[] $citiesResidence
 * @property CitiesList[] $citiesJobLocations
 */
class CvList extends CActiveRecord
{
    
    protected $controller;
    
    public $genderTypes;
    public $educationTypes;
    public $statusTypes;
    
    public $assistance_ids = array();
    public $residencies_ids = array();
    public $job_locations_ids = array();

    public function  init() {
        parent::init();
        
        $this->controller = Yii::app()->getController();
        $this->genderTypes = $this->controller->loadConfigFromFile('gender_types');
        $this->educationTypes = $this->controller->loadConfigFromFile('education_types');
        $this->statusTypes = $this->controller->loadConfigFromFile('cv_statuses');
        
    }
    
    public function getAssistances()
    {
        $html = '';
        if (is_array($this->assistanceTypes)) {
            $html = '<ul>';
            foreach ($this->assistanceTypes as $a) {
                $html .= "<li>" . $a->name . "</li>";
            }
            $html .= '</ul>';
        }
        return $html;
        
    }

    public function getEducationType()
    {
        return $this->educationTypes[$this->education];
    }

    public function getGenderType()
    {
        return $this->genderTypes[$this->gender];
    }
    
    public function getCvStatus()
    {
        return $this->statusTypes[$this->status];
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cv_list';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, first_name, last_name, birth_date, contact_phone, email, education, eduction_info, work_experience, skills, summary, desired_position, documents, applicant_type, cv_file, recruiter_id, recruiter_comments, added_time', 'required'),
            array('category_id, education, recruiter_id, status', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, desired_position, cv_file, who_filled', 'length', 'max' => 255),
            array('gender', 'length', 'max' => 1),
            array('contact_phone', 'length', 'max' => 15),
            array('id, category_id, first_name, last_name, gender, birth_date, contact_phone, email, education, eduction_info, work_experience, skills, summary, desired_position, documents, applicant_type, cv_file, recruiter_id, recruiter_comments, who_filled, added_time, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'recruiter' => array(self::BELONGS_TO, 'Users', 'recruiter_id'),
            'category' => array(self::BELONGS_TO, 'CvCategories', 'category_id'),
            'cvStatuses' => array(self::HAS_MANY, 'CvStatuses', 'cv_id'),
            'assistanceTypes' => array(self::MANY_MANY, 'AssistanceTypes', 'cv_to_assistance(cv_id, assistance_type_id)'),
            'citiesResidence' => array(self::MANY_MANY, 'CitiesList', 'cv_to_residence(cv_id, city_id)'),
            'citiesJobLocations' => array(self::MANY_MANY, 'CitiesList', 'cv_to_job_location(cv_id, city_id)'),
        );
    }

    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => 'Категорія',
            'first_name' => 'Ім’я',
            'last_name' => 'Призвище',
            'gender' => 'Стать',
            'birth_date' => 'Дата народження',
            'contact_phone' => 'Телефон',
            'email' => 'Електронна пошта',
            'education' => 'Освіта',
            'eduction_info' => 'Про освіту',
            'work_experience' => 'Досвід роботи',
            'skills' => 'Навички',
            'summary' => 'Резюме',
            'desired_position' => 'Бажана позиція',
            'job_locations_ids' => 'Бажане місце роботи',
            'documents' => 'Наявні документи (паспорт, права, диплом, трудова книжка)',
            'applicant_type' => 'Діяльність на Майдані / Внутрішні переселенці',
            'assistance_ids' => 'Потрібна допомога',
            'residencies_ids' => 'Місце проживання',
            'cv_file' => 'Файл резюме (лінк)',
            'recruiter_id' => 'Рекрутер',
            'recruiter_comments' => 'Коментарі рекрутера',
            'who_filled' => 'Хто заповнив',
            'added_time' => 'Додано',
            'status' => 'Статус',
        );
    }
    
    public function afterFind()
    {
        parent::afterFind();
        
        if (empty($this->residencies_ids)) {
            foreach ($this->citiesResidence as $name) {
                $this->residencies_ids[] = $name->city_index;
            }
        }
        if (empty($this->assistance_ids)) {
            foreach ($this->assistanceTypes as $a) {
                $this->assistance_ids[] = $a->id;
            }
        }
        if (empty($this->job_locations_ids)) {
            foreach ($this->citiesJobLocations as $j) {
                $this->job_locations_ids[] = $j->city_index;
            }
        }
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('contact_phone', $this->contact_phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('education', $this->education);
        $criteria->compare('eduction_info', $this->eduction_info, true);
        $criteria->compare('work_experience', $this->work_experience, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('desired_position', $this->desired_position, true);
        $criteria->compare('documents', $this->documents, true);
        $criteria->compare('applicant_type', $this->applicant_type, true);
        $criteria->compare('cv_file', $this->cv_file, true);
        $criteria->compare('recruiter_id', $this->recruiter_id);
        $criteria->compare('recruiter_comments', $this->recruiter_comments, true);
        $criteria->compare('who_filled', $this->who_filled, true);
        $criteria->compare('added_time', $this->added_time, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CvList the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
