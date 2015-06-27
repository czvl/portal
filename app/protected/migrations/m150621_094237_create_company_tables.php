<?php

class m150621_094237_create_company_tables extends CDbMigration
{
    public function up()
    {
        $this->createTable('companies', [
            'id' => 'pk',
            'name' => 'varchar(255) NOT NULL',
            'address' => 'varchar(1000)',
            'site_url' => 'varchar(255) DEFAULT NULL',
            'created_at' => 'datetime NOT NULL',
            'updated_at' => 'datetime NOT NULL'

        ], 'Engine=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable('companies');
    }

}