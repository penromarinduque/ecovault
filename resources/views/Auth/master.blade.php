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



    <img class="bg-auto w-36  left-0 right-0 mx-auto my-8 z-[60] text-red-800 rounded-full max-w-md"
        src="{{ asset('images/logo.png') }}" alt="logo">

    @yield('content')

</body>

</html>
