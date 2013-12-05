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

    static::validating(function($task)
    {
      $task->deleteEmptyOnUpdate();
    });
  }

  public function setTitleAttribute($title)
  {
    $this->attributes['title'] = trim($title);
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

  /**
   * If the title is empty and the model already exists, delete the task.
   *
   * @return boolean False if the task has been deleted, true otherwise.
   */
  protected function deleteEmptyOnUpdate()
  {
      if ($this->exists && empty($this->title))
      {
        $this->delete();
        return false;
      }

      return true;
  }
}