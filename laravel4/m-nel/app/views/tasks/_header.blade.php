
<header id="header">
  <h1>todos</h1>

  {{ Form::open(['route' => 'tasks.store']) }}

    {{ $errors->first('title', '<div id="validation-error" class="flash error">:message</div>') }}

    {{ Form::text('title', null, [
      'id' => 'new-todo',
      'placeholder' => 'What needs to be done?',
      'autofocus' => '',
      'autocomplete' => 'off'
    ]) }}

  {{ Form::close() }}
  
</header>