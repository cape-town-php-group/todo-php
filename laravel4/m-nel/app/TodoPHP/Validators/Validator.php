<?php namespace TodoPHP\Validators;

use Validator as V;

abstract class Validator {

  protected $errors;

  public function isValid(array $attributes)
  {
    $validation = V::make($attributes, static::$rules);

    if ($validation->fails())
    {
      $this->errors = $validation->messages();
      return false;
    }

    return true;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}