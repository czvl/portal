<?php

class m150627_154744_ater_table_users extends CDbMigration
{
    public function up()
    {
        $this->addColumn('users', 'phone','varchar(255) DEFAULT NULL');
        $this->addColumn('users', 'position','varchar(255) DEFAULT NULL');
        $this->addColumn('users', 'additional_contact','varchar(255) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('users', 'position');
        $this->dropColumn('users', 'phone');
        $this->dropColumn('users', 'additional_contact');
    }
}