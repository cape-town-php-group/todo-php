<?php

Route::model('task', 'Task');

Route::get('tasks', [
  'as' => 'home',
  'uses' => 'TasksController@index'
]);
Route::patch('tasks/clear-completed', [
  'as' => 'tasks.clearCompleted',
  'uses' => 'TasksController@clearCompleted'
]);
Route::patch('tasks/toggle-all', [
  'as' => 'tasks.toggleAll',
  'uses' => 'TasksController@toggleAll'
]);
Route::post('tasks', [
  'as' => 'tasks.store',
  'uses' => 'TasksController@store'
]);
Route::patch('tasks/{task}', [
  'as' => 'tasks.update',
  'uses' => 'TasksController@update'
]);
Route::delete('tasks/{task}', [
  'as' => 'tasks.destroy',
  'uses' => 'TasksController@destroy'
]);