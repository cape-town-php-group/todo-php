
<li {{ $task->completed?'class="completed"':'' }}>
  <div class="view">
    <input class="toggle" type="checkbox" {{ $task->completed?'checked':'' }}>
    
    <label>{{ $task->title }}</label>
    
    <a href="{{ route('tasks.destroy', $task->id) }}">
      <button class="destroy"></button>
    </a>
  </div>
  <input class="edit" value="{{ $task->title }}">
</li>