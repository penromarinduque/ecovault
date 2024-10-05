<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    @vite('resources/css/app.css')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="bg-gray-50">
    <div class="h-full w-full">
        <a href="#" class="flex items-center justify-center text-2xl font-semibold text-gray-900">
            <img class="bg-auto" src="{{ asset('images/logo.png') }}" alt="logo">
        </a>
        @yield('content')
    </div>
</body>

</html>
