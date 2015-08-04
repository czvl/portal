<?php

class m150804_103657_add_vacancy_indexes extends CDbMigration
{
    public function up()
    {
        $this->addColumn('vacancies', 'hash', 'varchar(32)');
        $this->createIndex('idx_hash', 'vacancies', 'hash');
        $this->createIndex('idx_status_close_time', 'vacancies', 'status, close_time');
    }

    public function down()
    {
        $this->dropColumn('vacancies', 'hash');
        $this->dropIndex('idx_status_close_time', 'vacancies');
    }
}
