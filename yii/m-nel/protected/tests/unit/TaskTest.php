<?php

class TaskTest extends CDbTestCase
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