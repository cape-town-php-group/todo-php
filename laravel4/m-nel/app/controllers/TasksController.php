<?php

class TasksController extends BaseController {
  public function index()
  {
    $tasks = Task::all();

    return View::make('tasks.index')->with('tasks', $tasks);
  }
}