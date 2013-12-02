
<li {{ $task->completed?'class="completed"':'' }}>

    <div class="view">
      <!-- Toggle form -->
      {{ Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'PATCH']) }}
        {{ Form::hidden('completed', '0') }}
        {{ Form::checkbox('completed', 1, $task->completed, [
          'class'  => 'toggle',
          'onChange' => 'this.form.submit()'
        ]) }}

        <label>{{ $task->title }}</label>
      {{ Form::close() }}
      
      <!-- Delete form -->
      {{ Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'DELETE']) }}
        <button class="destroy"></button>
      {{ Form::close() }}
    </div>

    <!-- Edit form -->
    {{ Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'PATCH']) }}
      {{ Form::text('title', null, ['class' => 'edit']) }}
    {{ Form::close() }}
</li>