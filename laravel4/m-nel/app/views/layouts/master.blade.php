<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Template • TodoPHP</title>

    {{ HTML::style('css/base.css') }}
    {{ HTML::style('css/app.css') }}
    
    {{ HTML::script('js/jquery.min.js') }}
  </head>
  <body>

    @yield('content')

    <script type="text/javascript">
      @section('scripts')
      @show
    </script>

  </body>
</html>