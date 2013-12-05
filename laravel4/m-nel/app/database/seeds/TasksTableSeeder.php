<?php

class TasksTableSeeder extends Seeder {

  public function run()
  {
    Task::create([
      'title'=>'Create TodoPHP with laravel',
      'completed'=>true,
    ]);
    Task::create([
      'title'=>'Rule the world',
      'completed'=>false,
    ]);
  }
}