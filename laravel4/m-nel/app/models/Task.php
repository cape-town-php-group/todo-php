<?php

class Task extends Eloquent {

  public $timestamps = false;

  public function scopeTodo($query)
  {
    return $query->whereCompleted(false);
  }
}