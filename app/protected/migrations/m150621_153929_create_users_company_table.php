<?php

class m150621_153929_create_users_company_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('user_to_company', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'company_id' => 'int(11) NOT NULL',
        ],'Engine=InnoDB CHARSET=utf8');

        $this->createIndex('idx_user_id', 'user_to_company', 'user_id', true);
        $this->addForeignKey('fk__utc_user_id', 'user_to_company', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropTable('user_to_company');
	}
}