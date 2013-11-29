<?php namespace TodoPHP\Services;

use TodoPHP\Validators\TaskValidator;
use TodoPHP\Validators\ValidationException;
use Task;

class TaskCreatorService {

  protected $validator;

  public function __construct(TaskValidator $validator)
  {
    $this->validator = $validator;
  }

  public function make(array $attributes)
  {
    // validate
    if ($this->validator->isValid($attributes))
    {
      // create
      Task::create([
        'title' => trim($attributes['title']),
      ]);

      return true;
    }

    throw new ValidationException('Task validation failed', $this->validator->getErrors());
  }
}