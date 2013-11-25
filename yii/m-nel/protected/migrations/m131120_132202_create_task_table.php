<?php

class m131120_132202_create_task_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('task', array(
            'id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT',
            'name VARCHAR(45) NOT NULL',
            'status INT(1) NOT NULL DEFAULT 0',
        ));
	}

	public function down()
	{
		echo "m131120_132202_create_todo_table does not support migration down.\n";
		return false;
	}
}