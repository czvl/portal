<?php

class m150709_175815_add_fields_to_table_user extends CDbMigration
{
	public function up()
	{
        $this->addColumn('users', 'hash', 'char(32) DEFAULT NULL');
        $this->addColumn('users', 'email_confirmed', 'DATETIME DEFAULT NULL');
        $this->createIndex('idx_hash', 'users', 'hash');
	}

	public function down()
	{
		$this->dropColumn('users', 'hash');
		$this->dropColumn('users', 'email_confirmed');
	}

}