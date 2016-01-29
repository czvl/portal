<?php

class m160128_152440_add_field_active_to_assistance_types extends CDbMigration
{
	public function up()
	{
        $this->addColumn('assistance_types', 'active', 'boolean DEFAULT 1');

        // Insert new values
        $this->insertMultiple('assistance_types', [
            ['id' => 7, 'name' => 'Консультація рекрутера (профоріентація, оріентація на ринку праці, допомога в складанні резюме, підготовка до співбесіди тощо)'],
            ['id' => 8, 'name' => 'Пропозиція працевлаштування з частковою зайнятістю'],
            // ['id' => 9, 'name' => 'Робота з наданням житла'],
            ['id' => 9, 'name' => 'Консультація коуча або психолога'],
            ['id' => 10, 'name' => 'Консультація юриста'],
        ]);

        // Mark values inactive according to https://github.com/czvl/portal/issues/36
        $this->update('assistance_types', ['active' => false], 'id IN (1, 2)');

	}

	public function down()
	{
        $this->update('assistance_types', ['active' => true], 'id IN (1, 2)');
        $this->delete('assistance_types', 'id IN (7, 8, 9, 10)');
        $this->dropColumn('assistance_types', 'active');
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
