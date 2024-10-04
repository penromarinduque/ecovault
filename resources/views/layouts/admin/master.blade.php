<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    @vite('resources/css/app.css')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include your CSS files here -->
</head>

<body class="bg-[#F4F2F2]">
    <!-- Header section -->
    @include('layouts.admin.partials.navigation')
    @include('layouts.admin.partials.sidebar')
    <!-- Main content section -->
    <div class="content ml-64 p-4 mt-20">
        @yield('content')
    </div>



</body>

</html>
