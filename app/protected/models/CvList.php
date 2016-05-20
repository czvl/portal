<?php

/**
 * This is the model class for table "cv_list".
 *
 * The followings are the available columns in table 'cv_list':
 * @property integer $id
 * @property integer $internal_num
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property integer $marital_status
 * @property string $birth_date
 * @property string $contact_phone
 * @property string $other_contacts
 * @property string $email
 * @property integer $education
 * @property string $eduction_info
 * @property string $work_experience
 * @property string $skills
 * @property string $summary
 * @property string $salary
 * @property string $desired_position   // deprecated
 * @property string $documents
 * @property string $applicant_type     // deprecated
 * @property string $cv_file
 * @property integer $recruiter_id
 * @property string $recruiter_comments
 * @property string $who_filled
 * @property string $last_update
 * @property string $added_time
 * @property string $verifyCode
 * @property integer $status
 * @property integer $is_active
 * @property integer $disability        // deprecated
 * @property string $foreign_english
 * @property string $foreign_germany
 * @property string $foreign_french
 * @property string $foreign_china
 * @property string $foreign_spain
 *
 * The followings are the available model relations:
 * @property User $recruiter
 */
class CvList extends CActiveRecord
{
    const IS_ACTIVE_PRESENT = 'yes';
    const IS_ACTIVE_DELETED = 'no';
    const AGE_MINIMUM = 16;

    public $genderTypes = array();
    public $categoryIds = array();
    public $positionsIds = array();
    public $driverLicensesIds = array();
    public $educationTypes = array();
    public $statusTypes = array();
    public $assistanceIds = array();
    public $residenciesIds = array();
    public $jobLocationsIds = array();
    public $maritalStatuses = array();
    public $desiredPositionsIds = array();
    public $disabilityGroups = array();
    public $applicantTypeIds = array();

    public $foreignTypes= array();

    public $personal_data;
    public $verifyCode;

    public function init()
    {
        parent::init();
        $this->genderTypes = Yii::app()->config->gender_types;
        $this->educationTypes = Yii::app()->config->education_types;
        $this->statusTypes = Yii::app()->config->statuses;
        $this->maritalStatuses = Yii::app()->config->marital_statuses;
        $this->disabilityGroups = Yii::app()->config->disability_groups;

        $this->foreignTypes = Yii::app()->config->foreign_types;
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
        return array(
            array('verifyCode','captcha','allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'public'),
            array('first_name, last_name, gender, contact_phone, birth_date, residenciesIds, education, jobLocationsIds, work_experience, skills, summary, desiredPositionsIds, applicantTypeIds', 'required'),
            array('marital_status, education, recruiter_id, status, disability', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, salary, desired_position, cv_file, who_filled', 'length', 'max' => 255),
            array('gender', 'length', 'max' => 1),
            array('contact_phone', 'match', 'pattern'=>'/^([+]?[0-9 \)\(\-]+)$/'),
            array('contact_phone', 'length', 'max' => 19),
            array('birth_date', 'type', 'type' => 'date', 'message' => 'Поле "Дата нарождення" має бути датою.',  'dateFormat' => 'yyyy-MM-dd'),
            array('birth_date', 'birthDateValidator'),
            array('email', 'email'),
            array('birth_date, other_contacts, eduction_info, work_experience, skills,
            summary, documents,
            recruiter_comments, residenciesIds, jobLocationsIds,
            driverLicensesIds, assistanceIds, personal_data, positionsIds, desiredPositionsIds, applicantTypeIds, foreign_english, foreign_germany, foreign_french, foreign_china, foreign_spain', 'safe'),

            array('contact_phone', 'existentUser', 'on' => 'public'),
            array('personal_data', 'required', 'on' => 'public'),
            array('personal_data', 'compare', 'compareValue' => true, 'message' => 'Вам потрібно погодитись надати нам Ваші персональні дані.', 'on' => 'public'),

            array('id, first_name, last_name, gender, marital_status, birth_date, contact_phone, other_contacts, email, education, eduction_info, work_experience, skills, summary, salary, desired_position, documents, cv_file, recruiter_id, recruiter_comments, who_filled, last_update, added_time, status, disability, foreign_english, foreign_germany, foreign_french, foreign_china, foreign_spain', 'safe', 'on' => 'search'),
        );
    }

    public function birthDateValidator()
    {
        if (strtotime('-' . self::AGE_MINIMUM . 'year') < strtotime($this->birth_date)) {
            $this->addError('birth_date', Yii::t('main', 'applicant.error.tooYoung', ['{years}' => self::AGE_MINIMUM]));
        }
    }

    public function existentUser($attribute)
    {
        if (!empty($this->first_name) && !empty($this->last_name) && !empty($this->contact_phone)) {
            $this->contact_phone = preg_replace('/[^0-9]/', '', $this->contact_phone);
            $user = CvList::model()->findByAttributes(array('first_name' => $this->first_name, 'last_name' => $this->last_name, 'contact_phone' => $this->contact_phone));
            if (!empty($user)) {
                $this->addError($attribute, 'Запис з такими данними вже є в базі. Будь ласка не заповнюйте анкету вдруге!');
            }
        }
    }

    public function behaviors()
    {
        return array('ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

    public function defaultScope()
    {
        return array(
            'condition' => "is_active = '" . self::IS_ACTIVE_PRESENT . "'"
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
            'recruiter' => array(self::BELONGS_TO, 'User', 'recruiter_id'),
            'cvStatuses' => array(self::HAS_MANY, 'CvStatuses', 'cv_id'),
            'categories' => array(self::MANY_MANY, 'CvCategories', 'cv_to_category(cv_id, category_id)'),
            'positions' => array(self::MANY_MANY, 'CvPositions', 'cv_to_position(cv_id, position_id)'),
            'desiredPositions' => array(self::MANY_MANY, 'CvPositions', 'cv_to_position_desired(cv_id, position_id)'),
            'driverLicensesTypes' => array(self::MANY_MANY, 'DriverLicenses', 'cv_to_driver_license(cv_id, license_id)'),
            'assistanceTypes' => array(self::MANY_MANY, 'AssistanceTypes', 'cv_to_assistance(cv_id, assistance_type_id)'),
            'citiesResidence' => array(self::MANY_MANY, 'CitiesList', 'cv_to_residence(cv_id, city_id)'),
            'citiesJobLocations' => array(self::MANY_MANY, 'CitiesList', 'cv_to_job_location(cv_id, city_id)'),
            'applicantTypes' => array(self::MANY_MANY, 'CvApplicantTypes', 'cv_to_applicant_type(cv_id, applicant_type_id)'),

        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'internal_num' => 'Внутрішній номер',
            'categoryIds' => 'Категорії',
            'first_name' => 'Ім’я',
            'last_name' => 'Прізвище',
            'first_last_name' => 'Ім’я Прізвище',
            'gender' => 'Стать',
            'marital_status' => 'Сімейний стан',
            'birth_date' => 'Дата народження',
            'contact_phone' => 'Телефон',
            'other_contacts' => 'Інші контакти (якщо є ще один телефон або пошта, скайп, соціальні мережі)',
            'email' => 'Електронна пошта',
            'education' => 'Освіта',
            'eduction_info' => 'Про освіту',
            'work_experience' => 'Досвід роботи',
            'skills' => 'Навички',
            'summary' => 'Додаткова інформація',
            'desired_position' => 'Бажана посада',
            'desiredPositionsIds' => 'Бажана посада',
            'positionsIds' => 'Можливі посади',
            'salary' => 'Побажання по зар.платні',
            'jobLocationsIds' => 'Бажане місто роботи',
            'documents' => 'Наявні документи (паспорт, права, диплом, трудова книжка)',
            'driverLicensesIds' => 'Водійські права',
            'assistanceIds' => 'Потрібна допомога',
            'residenciesIds' => 'Місто проживання, знаходження',
            'cv_file' => 'Файл резюме (посилання)',
            'recruiter_id' => 'Рекрутер',
            'recruiter_comments' => 'Коментарі рекрутера',
            'statuses' => 'Історія',
            'who_filled' => 'Хто заповнив',
            'added_time' => 'Додано',
            'status' => 'Стан',
            'is_active' => 'Включений/Вимкнений',
            'personal_data' => 'Я згоден(на) з обробкою та використанням моїх персональних даних',
            'disability' => 'Наявність інвалідності (вкажіть, будь ласка, групу)',
            'applicantTypeIds' => 'Інформація про претендента ЦЗВЛ',
            'verifyCode' => 'Код перевiрки',
            'foreignLanguageTypes' => 'Іноземні мови',
            'foreign_english' => 'Англійська мова',
            'foreign_germany' => 'Німецька мова',
            'foreign_french' => 'Французька мова',
            'foreign_china' => 'Китайська мова',
            'foreign_spain' => 'Іспанська мова'
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->added_time = new CDbExpression('NOW()');

                if (!Yii::app()->user->isGuest) {
                    $this->who_filled = Yii::app()->user->id;
                }
            }
            $this->last_update = new CDbExpression('NOW()');
            $this->contact_phone = preg_replace('/[^0-9]/', '', $this->contact_phone);

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        if (empty($this->residenciesIds)) {
            foreach ($this->citiesResidence as $name) {
                $this->residenciesIds[] = $name->city_index;
            }
        }
        if (empty($this->assistanceIds)) {
            foreach ($this->assistanceTypes as $a) {
                $this->assistanceIds[] = $a->id;
            }
        }
        if (empty($this->jobLocationsIds)) {
            foreach ($this->citiesJobLocations as $j) {
                $this->jobLocationsIds[] = $j->city_index;
            }
        }
        if (empty($this->categoryIds)) {
            foreach ($this->categories as $c) {
                $this->categoryIds[] = $c->id;
            }
        }
        if (empty($this->driverLicensesIds)) {
            foreach ($this->driverLicensesTypes as $d) {
                $this->driverLicensesIds[] = $d->id;
            }
        }
        if (empty($this->positionsIds)) {
            foreach ($this->positions as $p) {
                $this->positionsIds[] = $p->id;
            }
        }
        if (empty($this->desiredPositionsIds)) {
            foreach ($this->desiredPositions as $dp) {
                $this->desiredPositionsIds[] = $dp->id;
            }
        }
        if (empty($this->applicantTypeIds)) {
            foreach ($this->applicantTypes as $at) {
                $this->applicantTypeIds[] = $at->id;
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
        $criteria->compare('internal_num', $this->internal_num);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('marital_status', $this->marital_status);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('contact_phone', $this->contact_phone, true);
        $criteria->compare('other_contacts', $this->other_contacts, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('education', $this->education);
        $criteria->compare('eduction_info', $this->eduction_info, true);
        $criteria->compare('work_experience', $this->work_experience, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('summary', $this->summary, true);
        $criteria->compare('salary', $this->salary, true);
        $criteria->compare('desired_position', $this->desired_position, true);
        $criteria->compare('documents', $this->documents, true);
        $criteria->compare('cv_file', $this->cv_file, true);
        $criteria->compare('recruiter_id', $this->recruiter_id);
        $criteria->compare('recruiter_comments', $this->recruiter_comments, true);
        $criteria->compare('who_filled', $this->who_filled, true);
        $criteria->compare('last_update', $this->last_update, true);
        $criteria->compare('added_time', $this->added_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('disability', $this->disability);
        // Add to search criteries foreign languges
        $criteria->compare('foreign_english', $this->foreign_english);
        $criteria->compare('foreign_germany', $this->foreign_germany);
        $criteria->compare('foreign_french', $this->foreign_french);
        $criteria->compare('foreign_china', $this->foreign_china);
        $criteria->compare('foreign_spain', $this->foreign_spain);

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

    public function getStatusTypes()
    {
        $this->statusTypes = Yii::app()->config->statuses;
        return $this->statusTypes;
    }

	public function getGenderTypes()
	{
		$this->genderTypes = Yii::app()->config->gender_types;
		return $this->genderTypes;
	}
  // Return all level types of foreign languages
  public function getForeignTypes()
	{
		$this->foreignTypes = Yii::app()->config->foreign_types;
    unset($this->foreignTypes['n']);
		return $this->foreignTypes;
	}

    public function getDisabilityGroups()
    {
        $this->disabilityGroups = Yii::app()->config->disability_groups;
        return $this->disabilityGroups;
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

    public function getFlat_Assistances()
    {
        $rows = array();
        if (is_array($this->assistanceTypes)) {
            foreach ($this->assistanceTypes as $a) {
                $rows[] = $a->name;
            }
        }
        return implode("\n", $rows);

    }

    public function getLatestStatuses()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'cv_id = :cv_id';
        $criteria->params = array(':cv_id' => $this->id);
        $criteria->order = "added_time DESC";
        $criteria->limit = 3;

        return CvStatuses::model()->findAll($criteria);
    }

    public function getFirstLastName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getItemsByList(array $list)
    {
        if( !sizeof($list) ) return array();

        $criteria = new CDbCriteria();
        $criteria->addInCondition('id', $list);
        return self::model()->findAll($criteria);
    }

}
