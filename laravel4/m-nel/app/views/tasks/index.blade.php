<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Template • TodoPHP</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body>

    <section id="todoapp">

      <header id="header">
        <h1>todos</h1>
        <input id="new-todo" placeholder="What needs to be done?" autofocus>
      </header>

      <!-- This section should be hidden by default and shown when there are todos -->
      @if(count($tasks) > 0)
        @include('tasks._main')
        @include('tasks._footer')
      @endif

    </section>

    <footer id="info">
      <p>Double-click to edit a todo</p>
      <p>Created by <a href="https://github.com/m-nel">Michael Nel</a></p>
      <p>Part of <a href="https://github.com/cape-town-php-group/todo-php">TodoPHP</a></p>
    </footer>

  </body>
</html>