<?php

class Task extends Eloquent {

  public $timestamps = false;

  protected $guarded = ['id'];

  public static function boot()
  {
    parent::boot();

    static::saving(function($task)
    {
      // If the title is empty, delete it
      if (empty($task->title))
      {
        $task->delete();
        return false;
      }
    });
  }

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