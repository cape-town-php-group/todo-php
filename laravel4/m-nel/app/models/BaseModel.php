<?php

class BaseModel extends Eloquent {

  protected $errors;

  public static function boot()
  {
    parent::boot();

    static::saving(function($model)
    {
      return $model->validate();
    });
  }

  public function validate()
  {
    if ($this->fireModelEvent('validating') === false)
    {
      return false;
    }

    $validation = Validator::make($this->getAttributes(), static::$rules);

    if($validation->fails())
    {
      $this->errors = $validation->messages();
      return false;
    }

    $this->fireModelEvent('validated', false);

    return true;
  }

  public static function validating($callback)
  {
    static::registerModelEvent('validating', $callback);
  }

  public static function validated($callback)
  {
    static::registerModelEvent('validated', $callback);
  }

  public function getErrors()
  {
    return $this->errors;
  }
}