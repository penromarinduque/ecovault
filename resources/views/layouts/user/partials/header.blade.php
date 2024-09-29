<header class="h-20 bg-blue-500 w-full">
    <nav class="flex justify-between space-x-4 h-full mx-8">

        <div class="flex space-x-4 items-center">
            <img src="{{ asset('images/logo.png') }}" class="w-14 " alt="" srcset="">

            <div class="font-medium text-white">
                <h1>PENRO System</h1>
                <p>Boac Santol Marinduque</p>
            </div>
        </div>

        <div class="flex space-x-4 items-center">
            <a href="{{ route('login.show') }}" class="hover:cursor-pointer bg-white px-4 py-1 rounded-md">Login</a>
            <a href="{{ route('register.show') }}"
                class="hover:cursor-pointer bg-white px-4 py-1 rounded-md">Register</a>
        </div>



    </nav>
</header>
