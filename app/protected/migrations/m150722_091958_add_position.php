<?php

class m150722_091958_add_position extends CDbMigration
{
	public function up()
	{
        $this->insert('cv_positions', [
            'name' => 'Рятівник',
        ]);
	}

	public function down()
	{
        return true;
	}

}