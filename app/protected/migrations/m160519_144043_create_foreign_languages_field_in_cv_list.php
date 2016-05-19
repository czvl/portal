<?php

class m160519_144043_create_foreign_languages_field_in_cv_list extends CDbMigration
{
	public function up()
	{
    $this->addColumn('cv_list', 'foreign_english', "ENUM(  'n',  'a',  'b',  'c',  'd') NOT NULL DEFAULT  'n' ");
    $this->addColumn('cv_list', 'foreign_germany', "ENUM(  'n',  'a',  'b',  'c',  'd') NOT NULL DEFAULT  'n' ");
    $this->addColumn('cv_list', 'foreign_french', "ENUM(  'n',  'a',  'b',  'c',  'd') NOT NULL DEFAULT  'n' ");
    $this->addColumn('cv_list', 'foreign_spain', "ENUM(  'n',  'a',  'b',  'c',  'd') NOT NULL DEFAULT  'n' ");
    $this->addColumn('cv_list', 'foreign_china', "ENUM(  'n',  'a',  'b',  'c',  'd') NOT NULL DEFAULT  'n' ");
	}

	public function down()
	{
		$this->dropColumn('cv_list', 'foreign_english');
    $this->dropColumn('cv_list', 'foreign_germany');
    $this->dropColumn('cv_list', 'foreign_french');
    $this->dropColumn('cv_list', 'foreign_spain');
    $this->dropColumn('cv_list', 'foreign_china');
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