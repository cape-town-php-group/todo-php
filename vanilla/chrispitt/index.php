<?php

// start output buffering to get the initial list of tasks

ob_start();

// fake action so the api.php script returns a list of tasks

$_GET["action"] = "list";

// include api.php to render task json

include("api.php");

// get the json string

$json = ob_get_contents();

// end output buffering

ob_end_clean();

// get tasks out of json string

$data  = json_decode($json);
$tasks = $data->tasks;

// reset the content type header which api.php set

header("Content-type: text/html");

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Todo</title>
    <link rel="stylesheet" href="components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="main.css" />
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>todo</h1>
          <div class="list"></div>
      </div>
    </div>
  </div>
    <script>
      var TASKS = <?php echo json_encode($tasks); ?>;
    </script>
    <script src="components/react/react.js"></script>
    <script src="components/jquery/dist/jquery.js"></script>
    <script src="main.js"></script>
  </body>
</html>
