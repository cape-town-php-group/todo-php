
<footer id="footer">

  <!-- This should be `0 items left` by default -->
  <span id="todo-count">
    <strong>{{ Task::todo()->get()->count() }}</strong> item{{ Task::todo()->get()->count()==1?'':'s' }} left
  </span>

  <!-- Remove this if you don't implement routing -->
  <ul id="filters">
    <li>
      {{ link_to_route('home', 'All', [], ['class' => Request::query('filter')?'':'selected']) }}
      <!-- <a class="selected" href="{{ Request::url() }}">All</a> -->
    </li>
    <li>
      {{ link_to_route('home', 'Active', ['filter' => 'active'], ['class' => Request::query('filter') == 'active'?'selected':'']) }}
    </li>
    <li>
      {{ link_to_route('home', 'Completed', ['filter' => 'completed'], ['class' => Request::query('filter') == 'completed'?'selected':'']) }}
    </li>
  </ul>

  <!-- Hidden if no completed items are left ↓ -->
  @if(count(Task::completed()->get()))
    <!-- Clear completed form -->
    {{ Form::open(['route' => 'tasks.clearCompleted', 'method' => 'PATCH']) }}
      <button id="clear-completed">
        Clear completed ({{ Task::completed()->get()->count() }})
      </button>
    {{ Form::close() }}
  @endif

</footer>