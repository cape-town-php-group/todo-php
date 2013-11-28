
<section id="main">

  {{ Form::open(['route' => 'tasks.toggleAll', 'method' => 'put']) }}

    {{ Form::checkbox('toggleAll', '', !Task::hasTodo(), [
      'id' => 'toggle-all', 
      'title' => 'Mark all as complete', 
      'onChange' => 'this.form.submit()'
    ]) }}
  
  {{ Form::close() }}
  
  <ul id="todo-list">
    @foreach($tasks as $task)
      @include('tasks._task', ['task'=>$task])
    @endforeach
  </ul>

</section>