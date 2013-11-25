<?php

class TaskTest extends WebTestCase
{
    /**
     * Key codes
     */
    const KEY_ENTER = "\\13";
    const KEY_ESCAPE = "\\27";
    
    /**
     * Header components
     */
    const LOCATOR_TOGGLE_ALL_BUTTON = 'id=toggle-all';
    const LOCATOR_TOGGLE_ALL_BUTTON_CHECKED = "xpath=//input[@id='toggle-all' and @checked='checked']";
    const LOCATOR_NEW_TODO_INPUT = 'id=new-todo';
    
    /**
     * Task components
     */
    const LOCATOR_COMPLETED_TASK = "xpath=//li[@class='completed']";
    const LOCATOR_TASK_TOGGLE_CHECKED = "xpath=//input[@class='toggle' and @type='checkbox' and not(@checked)]";
    const LOCATOR_TASK_DESTROY_BUTTON = "xpath=//button[@class='destroy']";
    const LOCATOR_TASK_EDIT_INPUT = "xpath=//input[@class='edit']";
    const LOCATOR_TASK_LABEL = "//div[@class='view']//label";
    
    /**
     * Footer components
     */
    const LOCATOR_CLEAR_COMPLETED_BOTTON = 'id=clear-completed';
    
    /**
     * Fixtures
     */
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
		
        // Create new task
        $this->type(self::LOCATOR_NEW_TODO_INPUT, 'test task');
        $this->keyPressAndWait(self::LOCATOR_NEW_TODO_INPUT, self::KEY_ENTER);
        
        $this->assertEquals($numberOfTasks+1, (int)Task::model()->count());
    }
    
    /**
     * Test that the validation error is displayed to user
     */
    public function testValidationErrorDisplay()
    {
        $this->open('');
        
        $this->keyPressAndWait(self::LOCATOR_NEW_TODO_INPUT, self::KEY_ENTER);
        
        $this->assertElementPresent('id=validation-error');
    }
    
    /**
     * Test that the todo count in the #footer is accurate
     */
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
    
    /**
     * Test that the todo items are listed
     */
    public function testListTasks()
    {
        $this->open('');
        $this->assertTextPresent($this->tasks('task1')->name);
        $this->assertTextPresent($this->tasks('task2')->name);
    }
    
    /**
     * Test that completed tasks are presented as completed
     */
    public function testIndicateCompleted()
    {
        $this->open('');
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 1);
        
        $task = new Task;
        $task->name = 'Completed task';
        $task->status = Task::STATUS_COMPLETED;
        $this->assertTrue($task->save());
        
        $this->refreshAndWait(10000);
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 2);
        
        Task::clearCompleted();
        
        $this->refreshAndWait(10000);
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 0);
    }
    
    /**
     * Test that the toggle all button functions propperly
     */
    public function testToggleAll()
    {
        $this->open('');
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 1);
        
        $this->clickAndWait(self::LOCATOR_TOGGLE_ALL_BUTTON);
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 2);
        
        $this->clickAndWait(self::LOCATOR_TOGGLE_ALL_BUTTON);
        $this->assertXpathCount(self::LOCATOR_COMPLETED_TASK, 0);
    }
    
    /**
     * Test the clear completed button
     */
    public function testClearCompleted()
    {
        $this->open('');
        $this->assertTextPresent('Clear completed (1)');
        
        $this->clickAndWait(self::LOCATOR_TOGGLE_ALL_BUTTON);
        $this->assertTextPresent('Clear completed (2)');
        
        $this->clickAndWait(self::LOCATOR_CLEAR_COMPLETED_BOTTON);
        $this->assertTextNotPresent('Clear completed');
        
        $this->type(self::LOCATOR_NEW_TODO_INPUT, 'test task');
        $this->keyPressAndWait(self::LOCATOR_NEW_TODO_INPUT, self::KEY_ENTER);
        
        // Toggle all checkbox must be reset
        $this->assertXpathCount(self::LOCATOR_TOGGLE_ALL_BUTTON_CHECKED, 0);
    }
    
    /**
     * Test that the toggle task active/completed checkbox functions
     */
    public function testCompleteTask()
    {
        $this->open('');
        $this->assertXpathCount(self::LOCATOR_TASK_TOGGLE_CHECKED, 1);
        
        $this->clickAndWait(self::LOCATOR_TASK_TOGGLE_CHECKED);
        
        $this->assertXpathCount(self::LOCATOR_TASK_TOGGLE_CHECKED, 0);
    }
    
    /**
     * Test that the destroy task button functions
     */
    public function testDeleteTask()
    {
        $this->open('');
        $this->assertXpathCount(self::LOCATOR_TASK_DESTROY_BUTTON, 2);
        
        $this->clickAndWait(self::LOCATOR_TASK_DESTROY_BUTTON."[1]");
        
        $this->assertXpathCount(self::LOCATOR_TASK_DESTROY_BUTTON, 1);
    }
    
    /**
     * Test that double click on task label displays edit input.
     * Test that enter key press & onBlur(lose focus) event saves task
     */
    public function testTaskEditMode()
    {
        $this->open('');
        
        // Display edit input
        $this->assertNotVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        $this->doubleClick(self::LOCATOR_TASK_LABEL."[1]");
        $this->assertVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        
        // Edit the task & press enter
        $this->type(self::LOCATOR_TASK_EDIT_INPUT."[1]", 'edited');
        $this->keyPressAndWait(self::LOCATOR_TASK_EDIT_INPUT."[1]", self::KEY_ENTER);
        $this->assertNotVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        $this->assertText(self::LOCATOR_TASK_LABEL."[1]", 'edited');
        
        // Edit task & fire blur event
        $this->doubleClick(self::LOCATOR_TASK_LABEL."[1]");
        $this->assertVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        $this->type(self::LOCATOR_TASK_EDIT_INPUT."[1]", 're-edited');
        $this->fireEventAndWait(self::LOCATOR_TASK_EDIT_INPUT."[1]", "blur");
        $this->assertNotVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        $this->assertText(self::LOCATOR_TASK_LABEL."[1]", 're-edited');
    }
    
    /**
     * Test that when editing a task, pressing the escape button will canel editing
     */
    public function testTaskEscapeEditMode()
    {
        $this->open('');
        $this->assertNotVisible(self::LOCATOR_TASK_EDIT_INPUT."[1]");
        $this->doubleClick(self::LOCATOR_TASK_LABEL."[1]");
        $this->type(self::LOCATOR_TASK_EDIT_INPUT."[1]", 'edited');
        $this->keyDown(self::LOCATOR_TASK_EDIT_INPUT."[1]", self::KEY_ESCAPE);
        $this->assertVisible(self::LOCATOR_TASK_LABEL."[1]");
        $this->assertText(self::LOCATOR_TASK_LABEL."[1]", 'Rule the web');
    }
}