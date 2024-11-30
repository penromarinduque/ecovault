<header class="h-20 bg-blue-500 w-full absolute top-0">
    <nav class="flex justify-between space-x-4 h-full mx-8">

        <div class="flex space-x-4 items-center">
            <img src="{{ asset('images/denrlogo.png') }}" class="w-14 " alt="" srcset="">

            <div class="font-medium text-white">
                <h1>PENRO System</h1>
                <p>Boac Santol Marinduque</p>
            </div>
        </div>

        <div class="flex space-x-4 items-center">

            <a href="{{ route('register.show') }}"
                class="px-5 py-2.5 gap-1 text-sm font-medium text-white inline-flex items-center bg-transparent hover:bg-blue-800 focus:ring-4 focus:outline-white border boder-white focus:ring-blue-300 rounded-lg text-center">Register
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>

            </a>
        </div>



    </nav>
</header>
