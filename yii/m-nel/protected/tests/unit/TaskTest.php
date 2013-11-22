<?php

Yii::import('application.tests.DbTestCase');

class TaskTest extends DbTestCase
{
    public $fixtures=array(
        'tasks'=>'Task',
    );
    
    /**
     * Basic create task
     */
    public function testCreateTask()
    {
        // Insert a task
        $task = new Task;
        $task->name = 'Test create';
        $this->assertTrue($task->save());
    }
    
    /**
     * Test that when creating a task, the name is trimmed.
     */
    public function testTrimName()
    {
        $task = new Task;
        $task->name = '   Test trim   ';
        $this->assertTrue($task->save());
        
        $this->assertEquals($task->name, 'Test trim');
    }
    
    public function testEmptyName()
    {
        $task = new Task;
        $task->name = '';
        $this->assertFalse($task->save());
    }
    
    public function testCompleteScope()
    {
        $this->assertEquals((int)Task::model()->completed()->count(), 1);
        
        $this->tasks('task2')->delete();
        
        $this->assertEquals((int)Task::model()->completed()->count(), 0);
    }
}