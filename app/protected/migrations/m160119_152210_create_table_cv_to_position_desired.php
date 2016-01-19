<?php

class m160119_152210_create_table_cv_to_position_desired extends CDbMigration
{
	public function up()
	{
        // CREATE TABLE IF NOT EXISTS `cv_to_position` (
        //   `cv_id` int(11) NOT NULL,
        //   `position_id` int(11) NOT NULL
        // ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        $this->createTable('cv_to_position_desired', [
            'cv_id' => 'int(11) NOT NULL',
            'position_id' => 'int(11) NOT NULL',
            //  'PRIMARY KEY("cv_id", "position_id")'
        ], 'Engine=InnoDB CHARSET=utf8');

        // ALTER TABLE `cv_positions`
        //   ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

        $this->addPrimaryKey('PRIMARY', 'cv_to_position_desired', [
            'cv_id',
            'position_id',
        ]);

        $this->createIndex('position_id', 'cv_to_position_desired', 'position_id');
	}

	public function down()
	{
        $this->dropTable('cv_to_position_desired');
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
