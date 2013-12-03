<?php

class TasksController extends BaseController {

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
    $task = new Task(Input::all());

    if( ! $task->save())
    {
      return Redirect::home()->withErrors($task->getErrors());
    }

    return Redirect::home();
  }

  public function update($task)
  {
    $task->fill(Input::all());
    $task->save();

    return Redirect::home();
  }
}