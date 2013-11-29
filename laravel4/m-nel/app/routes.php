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
Route::put('tasks/toggle-all', [
  'as' => 'tasks.toggleAll',
  'uses' => 'TasksController@toggleAll'
]);
Route::post('tasks', [
  'as' => 'tasks.store',
  'uses' => 'TasksController@store'
]);