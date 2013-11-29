<?php

class Task extends Eloquent {

  public $timestamps = false;

  protected $guarded = ['id'];

  public function scopeTodo($query)
  {
    return $query->whereCompleted(false);
  }

  public function scopeCompleted($query)
  {
    return $query->whereCompleted(true);
  }

  public static function toggleAll()
  {
    DB::table('tasks')->update(['completed' => Task::hasTodo()]);
  }

  public static function hasTodo()
  {
    return Task::todo()->count() > 0;
  }
}