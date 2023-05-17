<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>AKK Blogs @yield('title')</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
		<script defer src="/assets/js/nav.js"></script> 

        <!-- Styles -->
		<link href="{{asset('/assets/css/main.css')}}" rel="stylesheet">
		<link href="{{asset('/assets/css/style.css')}}" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body>
        <div class="min-h-screen bg-pattern">
            <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
                {{ $slot }}
            </div>
        </div>
        @stack('modals')
        @livewireScripts
    </body>
</html>
