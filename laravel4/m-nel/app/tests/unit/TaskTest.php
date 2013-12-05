<?php

class TaskTest extends TestCase {

  public function setUp()
  {
    parent::setUp();

    Artisan::call('migrate');
    $this->seed();
  }

  public function tearDown()
  {
    Mockery::close();
  }

  protected function assertTodoCount($count)
  {
    $todoCount = Task::whereCompleted(false)->count();
    $this->assertEquals($count, $todoCount);
  }

  public function test_trims_title_when_set()
  {
    $expected = 'trimmed';

    $task = new Task;
    $task->title = '    trimmed     ';

    $this->assertEquals($expected, $task->title);
  }

  public function test_is_invalid_without_a_title()
  {
    $task = new Task;

    $this->assertFalse($task->validate(), 'Expected validation to fail.');
  }

  public function test_has_todo()
  {
    $this->assertTrue(Task::hasTodo());

    // Set all tasks to complete
    DB::table('tasks')->update(['completed' => true]);
    
    $this->assertFalse(Task::hasTodo());
  }

  public function test_scope_todo()
  {
    $this->assertEquals(1, Task::todo()->get()->count());
  }

  public function test_scope_completed()
  {
    $this->assertEquals(1, Task::completed()->get()->count());
  }

  public function test_filter_by_all()
  {
    $this->assertEquals(2, Task::filterBy('all')->count());
  }

  public function test_filter_by_invalid_option_defaults_to_all()
  {
    $filterByGiberish = Task::filterBy('giberish')->count();
    $filterByNull = Task::filterBy(null)->count();
    $filterByObject = Task::filterBy(new Task)->count();

    $this->assertEquals(2, $filterByGiberish);
    $this->assertEquals(2, $filterByNull);
    $this->assertEquals(2, $filterByObject);
  }

  public function test_filter_by_active()
  {
    $mock = Mockery::mock('Task[todo]');
    $mock->shouldReceive('todo')
         ->once();

    $mock->scopeFilterBy($mock, 'active');
  }

  public function test_filter_by_completed()
  {
    $mock = Mockery::mock('Task[completed]');
    $mock->shouldReceive('completed')
         ->once();

    $mock->scopeFilterBy($mock, 'completed');
  }

  public function test_toggle_all()
  {
    $this->assertTodoCount(1);

    Task::toggleAll();
    $this->assertTodoCount(0);

    Task::toggleAll();
    $this->assertTodoCount(2);
  }
}