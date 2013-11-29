
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

@section('scripts')
  @parent

  $('div.view>label').dblclick(function() {
    var view = $(this).parent();
    var task = view.parent().parent();
    task.addClass('editing');
    
    var edit = view.siblings('input.edit');
    edit.focus();
  });
  $('.edit').blur(function() {
    if($(this).parents('li').hasClass('editing')) {
      $(this).parent('form').submit();
    }
  });
  $('.edit').on('keydown', function(e) {
    if (e.keyCode == 27) {
      $(this).parents('li').removeClass('editing');
    }
  });
  
@stop