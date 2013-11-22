<?php

class TaskTest extends WebTestCase
{
    public $fixtures=array(
        'tasks'=>'Task',
    );
    
    /**
     * Basic sanity check
     */
	public function testIndex()
	{
		$this->open('');
		$this->assertTextPresent('todos');
	}
    
    /**
     * Ensure that when there are no tasks, #main & #footer is hidden.
     */
	public function testNoTodos()
	{
		$this->open('');
        $this->assertElementPresent('id=main');
        $this->assertElementPresent('id=footer');
        
        Task::model()->deleteAll();
        $this->assertEquals(0, (int)Task::model()->count());
        
		$this->refreshAndWait(10000);
        $this->assertElementNotPresent('id=main');
        $this->assertElementNotPresent('id=footer');
	}
    
    /**
     * Test if entering a value in the input and hitting enter creates a task.
     */
    public function testEnterCreatesNew()
    {
        $numberOfTasks = (int)Task::model()->count();
		
        $this->open('');
        // Enter a value for task name
        $this->type('id=new-todo', 'test task');
        // Hit enter
        $this->keyPress('id=new-todo', "\\13");
        
        $this->waitForPageToLoad(10000);
        $this->assertNotEquals($numberOfTasks, (int)Task::model()->count());
    }
    
    public function testValidationErrorDisplay()
    {
        $this->open('');
        
        // Hit enter
        $this->keyPress('id=new-todo', "\\13");
        $this->waitForPageToLoad(10000);
        
        $this->assertElementPresent('id=validation-error');
    }
    
    public function testTodoCount()
    {
        $this->open('');
        $this->assertTextPresent('1 item left');
        
        $task = new Task;
        $task->name = 'New task';
        $this->assertTrue($task->save());
        
        $this->refreshAndWait(10000);
        $this->assertTextPresent('2 items left');
        
        Task::model()->deleteAll(
            Task::model()->active()->getDbCriteria()
        );
        
        $this->refreshAndWait(10000);
        $this->assertTextPresent('0 items left');
    }
    
    public function testListTasks()
    {
        $this->open('');
        $this->assertTextPresent($this->tasks('task1')->name);
        $this->assertTextPresent($this->tasks('task2')->name);
    }
    
    public function testIndicateCompleted()
    {
        $this->open('');
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 1);
        
        $task = new Task;
        $task->name = 'Completed task';
        $task->status = Task::STATUS_COMPLETED;
        $this->assertTrue($task->save());
        
        $this->refreshAndWait(10000);
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 2);
        
        Task::model()->deleteAll(
            Task::model()->completed()->getDbCriteria()
        );
        
        $this->refreshAndWait(10000);
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 0);
    }
    
    public function testToggleAll()
    {
        $this->open('');
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 1);
        
        $this->click('id=toggle-all');
        $this->waitForPageToLoad(10000);
        
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 2);
        
        $this->click('id=toggle-all');
        $this->waitForPageToLoad(10000);
        
        $this->assertEquals($this->getXpathCount("xpath=//li[@class='completed']"), 0);
    }
}