<?php

class m150715_151316_create_table_cv_status_to_vacancy extends CDbMigration
{
	public function up()
	{
        $this->createTable('cv_status_to_vacancy', [
            'id' => 'pk',
            'cv_status_id' => 'int(11)',
            'vacancy_id' => 'int(11)',
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->createIndex('idx_cv_status_id', 'cv_status_to_vacancy', 'cv_status_id');
        $this->createIndex('vacancy_id', 'cv_status_to_vacancy', 'vacancy_id');
	}

	public function down()
	{
		$this->dropTable('cv_status_to_vacancy');
	}

}