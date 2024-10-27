<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Landing Page')</title>
    @vite('resources/css/app.css')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <!-- Include your CSS files here -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
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
