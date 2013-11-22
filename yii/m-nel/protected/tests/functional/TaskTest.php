<?php

class TaskTest extends WebTestCase
{
    const KEY_ENTER = "\\13";
    const KEY_ESCAPE = "\\27";
    
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
        $this->keyPress('id=new-todo', self::KEY_ENTER);
        
        $this->waitForPageToLoad(10000);
        $this->assertNotEquals($numberOfTasks, (int)Task::model()->count());
    }
    
    public function testValidationErrorDisplay()
    {
        $this->open('');
        
        $this->keyPress('id=new-todo', self::KEY_ENTER);
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
        
        Task::clearCompleted();
        
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
    
    public function testClearCompleted()
    {
        $this->open('');
        $this->assertTextPresent('Clear completed (1)');
        
        $this->click('id=toggle-all');
        $this->waitForPageToLoad(10000);
        
        $this->assertTextPresent('Clear completed (2)');
        
        $this->click('id=clear-completed');
        $this->waitForPageToLoad(10000);
        
        $this->assertTextNotPresent('Clear completed');
        
        // Toggle all checkbox must be reset
        $this->type('id=new-todo', 'test task');
        $this->keyPress('id=new-todo', self::KEY_ENTER);
        $this->waitForPageToLoad(10000);
        
        $this->assertEquals($this->getXpathCount("xpath=//input[@id='toggle-all' and @checked='checked']"), 0);
    }
    
    public function testCompleteTask()
    {
        $this->open('');
        $this->assertEquals(1, $this->getXpathCount("xpath=//input[@class='toggle' and @type='checkbox' and not(@checked)]"));
        
        $this->click("xpath=//input[@class='toggle' and @type='checkbox' and not(@checked)]");
        $this->refreshAndWait(10000);
        
        $this->assertEquals(0, $this->getXpathCount("xpath=//input[@class='toggle' and @type='checkbox' and not(@checked)]"));
    }
    
    public function testDeleteTask()
    {
        $this->open('');
        $this->assertEquals(2, $this->getXpathCount("xpath=//button[@class='destroy']"));
        
        $this->click("xpath=//button[@class='destroy'][1]");
        $this->refreshAndWait(10000);
        
        $this->assertEquals(1, $this->getXpathCount("xpath=//button[@class='destroy']"));
    }
    
    public function testTaskEditMode()
    {
        $this->open('');
        $this->assertFalse($this->isVisible("xpath=//input[@class='edit'][1]"));
        
        $this->doubleClick("//div[@class='view']//label[1]");
        $this->assertTrue($this->isVisible("xpath=//input[@class='edit'][1]"));
        
        $this->type("xpath=//input[@class='edit'][1]", 'edited');
        $this->keyPressAndWait("xpath=//input[@class='edit'][1]", self::KEY_ENTER);
        $this->assertFalse($this->isVisible("xpath=//input[@class='edit'][1]"));
        $this->assertEquals('edited', $this->getText("//div[@class='view']//label[1]"));
        
        $this->doubleClick("//div[@class='view']//label[1]");
        $this->assertTrue($this->isVisible("xpath=//input[@class='edit'][1]"));
        
        $this->type("xpath=//input[@class='edit'][1]", 're-edited');
        $this->fireEventAndWait("xpath=//input[@class='edit'][1]", "blur");
        $this->assertFalse($this->isVisible("xpath=//input[@class='edit'][1]"));
        $this->assertEquals('re-edited', $this->getText("//div[@class='view']//label[1]"));
    }
    
    public function testTaskEscapeEditMode()
    {
        $this->open('');
        $this->assertFalse($this->isVisible("xpath=//input[@class='edit'][1]"));
        $this->doubleClick("//div[@class='view']//label[1]");
        $this->type("xpath=//input[@class='edit'][1]", 'edited');
        $this->keyDown("xpath=//input[@class='edit'][1]", self::KEY_ESCAPE);
        $this->assertTrue($this->isVisible("//div[@class='view']//label[1]"));
        $this->assertEquals('Rule the web', $this->getText("//div[@class='view']//label[1]"));
    }
}