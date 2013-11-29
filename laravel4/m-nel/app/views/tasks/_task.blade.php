
<li {{ $task->completed?'class="completed"':'' }}>
  <div class="view">
  
    {{ Form::open(['route' => ['tasks.update', $task->id], 'method' => 'PUT']) }}
      {{ Form::hidden('completed', '0') }}
      {{ Form::checkbox('completed', 1, $task->completed, [
        'class'  => 'toggle',
        'onChange' => 'this.form.submit()'
      ]) }}
    {{ Form::close() }}

    <label>{{ $task->title }}</label>
    
    <a href="{{ route('tasks.destroy', $task->id) }}">
      <button class="destroy"></button>
    </a>
  </div>
  <input class="edit" value="{{ $task->title }}">
</li>