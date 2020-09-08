<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="/favicon.ico">

  @stack('meta')

  <title>
    @yield('title', 'Welcome')
    | {{ config('app.name', 'Laravel') }}
  </title>

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  @stack('stylesheets')
</head>
<body>
  <div id="app">
    @yield('content')
  </div>

  <script type='text/javascript'>
    window.App = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!}
  </script>

  <script src="{{ mix('js/app.js') }}"></script>

  @stack('javascripts')
</body>
</html>
