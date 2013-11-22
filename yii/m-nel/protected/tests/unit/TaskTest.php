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
    
    public function testActiveScope()
    {
        $this->assertEquals((int)Task::model()->active()->count(), 1);
        
        $this->tasks('task1')->delete();
        
        $this->assertEquals((int)Task::model()->active()->count(), 0);
    }
    
    public function testIsComplete()
    {
        $this->assertFalse($this->tasks('task1')->isCompleted());
        $this->assertTrue($this->tasks('task2')->isCompleted());
    }
    
    public function testToggleAll()
    {
        $this->assertEquals((int)Task::model()->active()->count(), 1);
        $this->assertEquals((int)Task::model()->completed()->count(), 1);
        
        Task::toggleAll(true);
        
        $this->assertEquals((int)Task::model()->active()->count(), 0);
        $this->assertEquals((int)Task::model()->completed()->count(), 2);
        
        Task::toggleAll(false);
        
        $this->assertEquals((int)Task::model()->active()->count(), 2);
        $this->assertEquals((int)Task::model()->completed()->count(), 0);
    }
    
    public function testClearCompleted()
    {
        $this->assertEquals((int)Task::model()->completed()->count(), 1);
        
        Task::clearCompleted();
        
        $this->assertEquals((int)Task::model()->completed()->count(), 0);
    }
    
    public function testTaskCounts()
    {
        $this->assertEquals(Task::getActiveTasksCount(), 1);
        $this->assertEquals(Task::getCompletedTasksCount(), 1);
        $this->assertFalse(Task::areAllTasksCompleted());
        
        Task::toggleAll(true);
        
        $this->assertEquals(Task::getActiveTasksCount(), 0);
        $this->assertEquals(Task::getCompletedTasksCount(), 2);
        $this->assertTrue(Task::areAllTasksCompleted());
        
        Task::toggleAll(false);
        
        $this->assertEquals(Task::getActiveTasksCount(), 2);
        $this->assertEquals(Task::getCompletedTasksCount(), 0);
        $this->assertFalse(Task::areAllTasksCompleted());
    }
    
    public function testCompleteTask()
    {
        $this->assertFalse($this->tasks('task1')->isCompleted());
        $this->assertTrue($this->tasks('task1')->toggleStatus());
        $this->assertTrue($this->tasks('task1')->isCompleted());
    }
}