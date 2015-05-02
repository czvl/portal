<?php

class m150501_084130_create_user_responsibility_tables extends CDbMigration
{
	public function up()
	{
        $this->createTable('user_to_cities', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'city_index' => 'char(5) NOT NULL',
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->createTable('user_to_cv_categories', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'cv_category_id' => 'int(11) NOT NULL',
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->createIndex('idx_user_id', 'user_to_cities', 'user_id');
        $this->createIndex('idx_user_id', 'user_to_cv_categories', 'user_id');

        $this->addForeignKey('fk_utc_user_id', 'user_to_cities', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_utcv_user_id', 'user_to_cv_categories', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropTable('user_to_cities');
		$this->dropTable('user_to_cv_categories');
	}
}