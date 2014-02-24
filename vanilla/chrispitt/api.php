<?php

$action = $_GET["action"];

$dbPath      = __DIR__ . "/todo.db";
$dbCreateSql = "CREATE TABLE task(id INTEGER PRIMARY KEY, description TEXT, done INTEGER, deleted INTEGER);";
$dbInsertSql = "INSERT INTO task (description, done, deleted) VALUES (:description, :done, :deleted);";
$dbUpdateSql = "UPDATE task SET description = :description WHERE id = :id";
$dbDoneSql   = "UPDATE task SET done = 1 WHERE id = :id";
$dbDeleteSql = "UPDATE task SET deleted = 1 WHERE id = :id";
$dbSelectSql = "SELECT * FROM task WHERE deleted = 0;";

if ($action === "reset") {

  // delete old db file

  if (file_exists($dbPath)) {
    unlink($dbPath); 
  }

  // connect to db

  $db = new PDO("sqlite:" . $dbPath);

  // create task table

  $db->exec($dbCreateSql);

  // insert three sample tasks

  $statement = $db->prepare($dbInsertSql);
  $statement->bindValue(":description", "The first task", PDO::PARAM_STR);
  $statement->bindValue(":done", 1, PDO::PARAM_INT);
  $statement->bindValue(":deleted", 0, PDO::PARAM_INT);
  $statement->execute();

  $statement = $db->prepare($dbInsertSql);
  $statement->bindValue(":description", "The second task", PDO::PARAM_STR);
  $statement->bindValue(":done", 0, PDO::PARAM_INT);
  $statement->bindValue(":deleted", 0, PDO::PARAM_INT);
  $statement->execute();

  $statement = $db->prepare($dbInsertSql);
  $statement->bindValue(":description", "The third task", PDO::PARAM_STR);
  $statement->bindValue(":done", 0, PDO::PARAM_INT);
  $statement->bindValue(":deleted", 0, PDO::PARAM_INT);
  $statement->execute();

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action
  ]);

}

if ($action === "list") {

  // connect to the db

  $db = new PDO("sqlite:" . $dbPath);

  // fetch all tasks

  $tasks = $db->query($dbSelectSql)->fetchAll(PDO::FETCH_ASSOC);

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action,
    "tasks"  => $tasks
  ]);

}

if ($action === "add") {

  // connect to the db

  $db = new PDO("sqlite:" . $dbPath);

  // insert a new task
  
  $statement = $db->prepare($dbInsertSql);
  $statement->bindValue(":description", $_GET["description"], PDO::PARAM_STR);
  $statement->bindValue(":done", 0, PDO::PARAM_INT);
  $statement->bindValue(":deleted", 0, PDO::PARAM_INT);
  $statement->execute();

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action
  ]);

}

if ($action === "update") {

  // connect to the db

  $db = new PDO("sqlite:" . $dbPath);

  // update an existing task
  
  $statement = $db->prepare($dbUpdateSql);
  $statement->bindValue(":description", $_GET["description"], PDO::PARAM_STR);
  $statement->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
  $statement->execute();

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action
  ]);

}

if ($action === "done") {

  // connect to the db

  $db = new PDO("sqlite:" . $dbPath);

  // mask an existing task as done
  
  $statement = $db->prepare($dbDoneSql);
  $statement->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
  $statement->execute();

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action
  ]);

}

if ($action === "delete") {

  // connect to the db

  $db = new PDO("sqlite:" . $dbPath);

  // mark an existing task as deleted
  
  $statement = $db->prepare($dbDeleteSql);
  $statement->bindValue(":id", $_GET["id"], PDO::PARAM_INT);
  $statement->execute();

  // respond

  header("Content-type: application/json");

  echo json_encode([
    "status" => "ok",
    "action" => $action
  ]);

}
