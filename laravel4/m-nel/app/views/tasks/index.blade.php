@extends('layouts.master')

@section('content')

    <section id="todoapp">
      @include('tasks._header')

      <!-- This section should be hidden by default and shown when there are todos -->
      @if(count($tasks) > 0)
        @include('tasks._main')
        @include('tasks._footer')
      @endif
    </section>

    <footer id="info">
      <p>Double-click to edit a todo</p>
      <p>Created by <a href="https://github.com/m-nel">Michael Nel</a></p>
      <p>Part of <a href="https://github.com/cape-town-php-group/todo-php">TodoPHP</a></p>
    </footer>
@stop