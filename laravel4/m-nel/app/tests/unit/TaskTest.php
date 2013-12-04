<?php

class TaskTest extends TestCase {

  public function test_trims_title_when_set()
  {
    $expected = 'trimmed';

    $task = new Task;
    $task->title = '    trimmed     ';

    $this->assertEquals($expected, $task->title);
  }
}