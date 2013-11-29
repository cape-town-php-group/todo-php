
<footer id="footer">

  <!-- This should be `0 items left` by default -->
  <span id="todo-count">
    <strong>{{ count(Task::todo()->get()) }}</strong> item{{ count(Task::todo()->get())==1?'':'s' }} left
  </span>

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
  @if(count(Task::completed()->get()))
    <a href="{{ route('tasks.clearCompleted') }}">
      <button id="clear-completed">Clear completed ({{ count(Task::completed()->get()) }})</button>
    </a>
  @endif

</footer>