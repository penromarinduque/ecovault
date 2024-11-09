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
            <a href="{{ route('login.show') }}"
                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">Login

                <a href="{{ route('register.show') }}"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">Register</a>
        </div>



    </nav>
</header>
