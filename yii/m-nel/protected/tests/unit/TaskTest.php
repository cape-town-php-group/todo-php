<?php

Yii::import('application.tests.DbTestCase');

class TaskTest extends DbTestCase
{
    public $fixtures=array(
        'tasks'=>'Task',
    );
    
    /**
     * Temporary test
     */
    public function testTemp()
    {
        $this->assertTrue(true);
    }
}