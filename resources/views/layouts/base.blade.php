<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('favicons/favicon.ico') }}">

  <meta property="og:image" content="{{ Site::logo() }}">

  @stack('meta')

  <title>
    @hasSection('title')
      @yield('title', 'Welcome') |
    @endif
    {{ Site::title() }}
  </title>

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  @stack('stylesheets')

  @if(config('analytics.measurement_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.measurement_id') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ config('analytics.measurement_id') }}');
    </script>
  @endif
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
