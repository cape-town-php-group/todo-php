<?php

use TodoPHP\Services\TaskCreatorService;
use TodoPHP\Validators\ValidationException;

class TasksController extends BaseController {
  
  protected $taskCreator;

  public function __construct(TaskCreatorService $taskCreator)
  {
    $this->taskCreator = $taskCreator;
  }

  public function index()
  {
    $filter = Input::get('filter', 'all');
    $tasks = Task::filterBy($filter)->get();

    return View::make('tasks.index')->with('tasks', $tasks);
  }

  public function destroy($task)
  {
    $task->delete();
    
    return Redirect::home();
  }

  public function clearCompleted()
  {
    Task::completed()->delete();

    return Redirect::home();
  }

  public function toggleAll()
  {
    Task::toggleAll();

    return Redirect::home();
  }

  public function store()
  {
    try 
    {
      $this->taskCreator->make(Input::all());
    } 
    catch(ValidationException $e)
    {
      return Redirect::home()->withErrors($e->getErrors());
    }

    return Redirect::home();
  }

  public function update($task)
  {
    // Yeah, I know... should not do this
    $task->fill(Input::all());
    $task->save();

    return Redirect::home();
  }
}