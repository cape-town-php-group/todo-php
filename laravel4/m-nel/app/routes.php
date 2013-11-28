<?php

Route::model('task', 'Task');

Route::get('tasks', [
  'as' => 'home',
  'uses' => 'TasksController@index'
]);
Route::get('tasks/{task}', [
  'as' => 'tasks.destroy',
  'uses' => 'TasksController@destroy'
]);