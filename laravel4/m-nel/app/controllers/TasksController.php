<?php

class TasksController extends BaseController {
  
  public function index()
  {
    $tasks = Task::all();

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
}