<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>
<body>
    <div class="bg-primary">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
