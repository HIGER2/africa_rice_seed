<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel Inertia') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @inertiaHead
</head>
<body class="antialiased">
    @inertia
</body>
</html>
