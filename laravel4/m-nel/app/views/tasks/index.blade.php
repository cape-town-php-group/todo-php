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
        <section id="main">
          <input id="toggle-all" type="checkbox">
          <label for="toggle-all">Mark all as complete</label>
          <ul id="todo-list">
            <!-- These are here just to show the structure of the list items -->
            <!-- List items should get the class `editing` when editing and `completed` when marked as completed -->
            <li class="completed">
              <div class="view">
                <input class="toggle" type="checkbox" checked>
                <label>Create a TodoMVC template</label>
                <button class="destroy"></button>
              </div>
              <input class="edit" value="Create a TodoMVC template">
            </li>
            <li>
              <div class="view">
                <input class="toggle" type="checkbox">
                <label>Rule the web</label>
                <button class="destroy"></button>
              </div>
              <input class="edit" value="Rule the web">
            </li>
          </ul>
        </section>
      @endif

      <!-- This footer should hidden by default and shown when there are todos -->
      <footer id="footer">
        <!-- This should be `0 items left` by default -->
        <span id="todo-count"><strong>1</strong> item left</span>
        <!-- Remove this if you don't implement routing -->
        
        <ul id="filters">
          <li>
            <a class="selected" href="#/">All</a>
          </li>
          <li>
            <a href="#/active">Active</a>
          </li>
          <li>
            <a href="#/completed">Completed</a>
          </li>
        </ul>

        <!-- Hidden if no completed items are left ↓ -->
        <button id="clear-completed">Clear completed (1)</button>
      </footer>
    </section>

    <footer id="info">
      <p>Double-click to edit a todo</p>
      <p>Created by <a href="https://github.com/m-nel">Michael Nel</a></p>
      <p>Part of <a href="https://github.com/cape-town-php-group/todo-php">TodoPHP</a></p>
    </footer>

  </body>
</html>