<?php

class m150705_134024_add_field_experience_to_vacancy_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('experiences', [
            'id' => 'int(11) PRIMARY KEY',
            'name' => 'varchar(255)'
        ], 'Engine=InnoDB CHARSET=utf8');


        $this->execute("INSERT INTO experiences (id, name) VALUES
        (1, 'не важливо'),
        (2, 'без досвіду роботи'),
        (3, 'мінімальний досвід роботи'),
        (4, 'досвід роботи на відповідній посаді')
        ");


        $this->addColumn('vacancies', 'experience_id', 'int(11)');
	}

	public function down()
	{
		$this->dropColumn('vacancies', 'experience_id');
	}
}