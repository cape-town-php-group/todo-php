
<li {{ $task->completed?'class="completed"':'' }}>

  {{ Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'PUT']) }}

    <div class="view">
      {{ Form::hidden('completed', '0') }}
      {{ Form::checkbox('completed', 1, $task->completed, [
        'class'  => 'toggle',
        'onChange' => 'this.form.submit()'
      ]) }}

      <label>{{ $task->title }}</label>
      
      <a href="{{ route('tasks.destroy', $task->id) }}">
        <button class="destroy"></button>
      </a>
    </div>

    {{ Form::text('title', null, ['class' => 'edit']) }}
  {{ Form::close() }}
</li>