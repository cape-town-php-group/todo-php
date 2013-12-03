<?php

class Task extends BaseModel {

  public $timestamps = false;

  protected $fillable = ['title','completed'];

  protected static $rules = [
    'title' => 'required'
  ];

  public static function boot()
  {
    parent::boot();

    // Delete task if the title is empty
    static::validating(function($task)
    {
      if ($task->exists && empty($task->title))
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

  public function scopeFilterBy($query, $by)
  {
    switch($by)
    {
      case 'active';
        return $query->todo();
      case 'completed';
        return $query->completed();
      default:
        return $query;
    }
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