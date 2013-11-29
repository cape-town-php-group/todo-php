<?php namespace TodoPHP\Validators;

class TaskValidator extends Validator {

  protected static $rules = [
    'title' => 'required'
  ];

}