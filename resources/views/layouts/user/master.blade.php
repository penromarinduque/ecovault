<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    @vite('resources/css/app.css')
    <!-- Include your CSS files here -->
</head>

<body>
    <!-- Header section -->
    @include('layouts.user.partials.header')

    <!-- Main content section -->
    <div class="content">
        @yield('content')
    </div>

    @include('layouts.user.partials.footer')

</body>

</html>
