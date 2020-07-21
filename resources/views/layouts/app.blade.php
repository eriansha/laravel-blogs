<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ $title ?? 'Laravel7' }}</title>
      <link rel="stylesheet" href="/css/bootstrap.min.css">
      @yield('head')
    </head>
    <body>
        @include('layouts.navigation')
        <div class="py-4">
          @yield('content')
        </div>
    </body>
</html>
