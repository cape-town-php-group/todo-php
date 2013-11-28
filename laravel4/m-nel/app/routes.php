<?php

Route::model('task', 'Task');

Route::get('tasks', [
  'as' => 'home',
  'uses' => 'TasksController@index'
]);
Route::get('tasks/{task}/destroy', [
  'as' => 'tasks.destroy',
  'uses' => 'TasksController@destroy'
]);
Route::get('tasks/clear-completed', [
  'as' => 'tasks.clearCompleted',
  'uses' => 'TasksController@clearCompleted'
]);