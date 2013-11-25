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
    
    /**
     * Test validation that name may not be empty on create.
     */
    public function testEmptyName()
    {
        $task = new Task;
        $task->name = '';
        $this->assertFalse($task->save());
    }
    
    /**
     * Test the 'completed' scope
     */
    public function testCompleteScope()
    {
        $this->assertEquals(1, (int)Task::model()->completed()->count());
        
        $this->tasks('task2')->delete();
        
        $this->assertEquals(0, (int)Task::model()->completed()->count());
    }
    
    /**
     * Test the 'active' scope
     */
    public function testActiveScope()
    {
        $this->assertEquals(1, (int)Task::model()->active()->count());
        
        $this->tasks('task1')->delete();
        
        $this->assertEquals(0, (int)Task::model()->active()->count());
    }
    
    /**
     * Test isCompleted() function
     */
    public function testIsComplete()
    {
        $this->assertFalse($this->tasks('task1')->isCompleted());
        $this->assertTrue($this->tasks('task2')->isCompleted());
    }
    
    /**
     * Test the toggle all functionality.
     * toggleAll(true)  => all completed
     * toggleAll(false) => all active
     */
    public function testToggleAll()
    {
        $this->assertEquals(1, (int)Task::model()->active()->count());
        $this->assertEquals(1, (int)Task::model()->completed()->count());
        
        Task::toggleAll(true);
        
        $this->assertEquals(0, (int)Task::model()->active()->count());
        $this->assertEquals(2, (int)Task::model()->completed()->count());
        
        Task::toggleAll(false);
        
        $this->assertEquals(2, (int)Task::model()->active()->count());
        $this->assertEquals(0, (int)Task::model()->completed()->count());
    }
    
    /**
     * Clear completed should delete any completed tasks
     */
    public function testClearCompleted()
    {
        $this->assertEquals(1, (int)Task::model()->completed()->count());
        
        Task::clearCompleted();
        
        $this->assertEquals(0, (int)Task::model()->completed()->count());
    }
    
    /**
     * Test task count methods
     */
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
    
    /**
     * Test the toggle status function
     */
    public function testToggleStatus()
    {
        $this->assertFalse($this->tasks('task1')->isCompleted());
        $this->assertTrue($this->tasks('task1')->toggleStatus());
        $this->assertTrue($this->tasks('task1')->isCompleted());
        $this->assertTrue($this->tasks('task1')->toggleStatus());
        $this->assertFalse($this->tasks('task1')->isCompleted());
    }
    
    /**
     * Test that when a task is updated with an empty name, 
     * the task should be deleted
     */
    public function testDeleteIfEmptyName()
    {
        $task = Task::model()->findByAttributes(array(
            'name'=>'Create a TodoPHP app',
        ));
        $this->assertNotNull($task);
        
        $task->scenario = 'update';
        $task->name = '';
        $task->save();
        
        $task = Task::model()->findByAttributes(array(
            'name'=>'Create a TodoPHP app',
        ));
        $this->assertNull($task);
    }
}