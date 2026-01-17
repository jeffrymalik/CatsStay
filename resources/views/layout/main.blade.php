<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Cats Stay')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{asset('css/main.css')}}">

  @yield('css')
</head>
<body>
    {{-- NAVBAR --}}
    @include('component.nav')

    {{-- CONTENT --}}
    @yield('content')

    @include('component.footer')
</body>
<script src="{{asset('js/main.js')}}"></script>
@yield('js')
</html>