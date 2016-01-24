<?php

class m160120_083258_add_field_disability_to_cv_list_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn('cv_list', 'disability', 'int(11) DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('cv_list', 'disability');
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
