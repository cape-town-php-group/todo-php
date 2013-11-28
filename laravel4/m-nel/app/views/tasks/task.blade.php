
<li {{ $task->completed?'class="completed"':'' }}>
  <div class="view">
    <input class="toggle" type="checkbox" {{ $task->completed?'checked':'' }}>
    <label>{{ $task->title }}</label>
    <button class="destroy"></button>
  </div>
  <input class="edit" value="{{ $task->title }}">
</li>