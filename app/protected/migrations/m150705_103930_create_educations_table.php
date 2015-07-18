<?php

class m150705_103930_create_educations_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('educations', [
            'id' => 'int(11) PRIMARY KEY',
            'name' => 'varchar(255)'
        ], 'Engine=InnoDB CHARSET=utf8');

        $this->execute("INSERT INTO educations (id, name) VALUES
        (1, 'незакінчена середня'),
        (2, 'середня'),
        (6, 'незакінчена середня спеціальна'),
        (3, 'середня спеціальна'),
        (4, 'незакінчена вища'),
        (5, 'вища')");
    }

    public function down()
    {
        $this->dropTable('educations');
    }

}