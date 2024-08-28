<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ env('APP_NAME') }} - {{ $title ?? ':)' }}</title>
    @vite('resources/scss/app.scss')
    @yield('css')
</head>

<body class="antialiased">
    @if (auth()->check())
        <x-header></x-header>
    @endif
    {{-- class="container d-flex justify-content-center align-items-center" --}}
    <div id="app" class="my-4">
        {{ $slot }}
    </div>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
