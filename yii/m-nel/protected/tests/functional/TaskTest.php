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
}