<?php

class m160203_132455_create_applicant_types_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('cv_applicant_types', [
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->createTable('cv_to_applicant_type', [
            'cv_id' => 'int(11) NOT NULL',
            'applicant_type_id' => 'int(11) NOT NULL',
        ], 'Engine=InnoDB CHARSET=utf8');

        // Add indices
        // $this->addPrimaryKey('PRIMARY', 'cv_applicant_types', 'id');
        $this->createIndex('name', 'cv_applicant_types', 'name', true);

        $this->addPrimaryKey('PRIMARY', 'cv_to_applicant_type', [
            'cv_id',
            'applicant_type_id',
        ]);
        $this->createIndex('applicant_type_id', 'cv_to_applicant_type', 'applicant_type_id');

        // Add values to cv_applicant_types
        $this->insertMultiple('cv_applicant_types', [
            ['id' => 1, 'name' => 'Учасник протестів на Майдані'],
            ['id' => 2, 'name' => 'Внутрішньо Переміщена Особа (з Криму, зі Сходу України)'],
            ['id' => 3, 'name' => 'Учасник АТО, члени сім\'ї учасників АТО (чоловік/жінка, діти, батьки)'],
        ]);
	}


	public function down()
	{
        $this->dropTable('cv_to_applicant_type');
        $this->dropTable('cv_applicant_types');
    }

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
