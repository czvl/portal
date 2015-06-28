<?php

class m150628_101823_create_table_vacancies extends CDbMigration
{
    public function up()
    {
        $this->createTable('vacancies', [
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
            'company_id' => 'int(11) NOT NULL',
            'city_id' => 'int(11) NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'description' => 'text',
            'requirements' => 'text',
            'status' => 'tinyint(3) NOT NULL',
            'housing' => 'tinyint(3) NOT NULL',
            'close_time' => 'datetime NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'datetime NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->createTable('vacancy_to_education', [
            'id' => 'pk',
            'vacancy_id' => 'int(11) NOT NULL',
            'education_id' => 'int(11) NOT NULL',
        ],'Engine=InnoDB CHARSET=utf8');
        $this->createIndex('idx_vacancy', 'vacancy_to_education', 'vacancy_id');
        $this->createIndex('idx_education', 'vacancy_to_education', 'education_id');

        $this->createTable('vacancy_to_category', [
            'id' => 'pk',
            'vacancy_id' => 'int(11) NOT NULL',
            'category_id' => 'int(11) NOT NULL',
        ],'Engine=InnoDB CHARSET=utf8');
        $this->createIndex('idx_vacancy', 'vacancy_to_category', 'vacancy_id');
        $this->createIndex('idx_category', 'vacancy_to_category', 'category_id');

        $this->createTable('vacancy_to_position', [
            'id' => 'pk',
            'vacancy_id' => 'int(11) NOT NULL',
            'position_id' => 'int(11) NOT NULL',
        ],'Engine=InnoDB CHARSET=utf8');
        $this->createIndex('idx_vacancy', 'vacancy_to_position', 'vacancy_id');
        $this->createIndex('idx_position', 'vacancy_to_position', 'position_id');
    }

    public function down()
    {
        $this->dropTable('vacancies');
        $this->dropTable('vacancy_to_education');
        $this->dropTable('vacancy_to_category');
        $this->dropTable('vacancy_to_position');
    }
}