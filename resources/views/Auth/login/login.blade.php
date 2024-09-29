<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>

    <div class="h-full w-full">
        <section class="bg-gray-50 ">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 ">
                    <img class="bg-auto" src="{{ asset('images/logo.png') }}" alt="logo">
                </a>
                <div class="w-screen bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0  ">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                            Create an account
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your
                                    email</label>
                                <input type="email" id="email" name="email"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="user@gmail.com" required />
                            </div>
                            <div class="mb-5">
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                                    password</label>
                                <input type="password" id="password" name="password"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    required />
                            </div>

                            <div class="flex justify-between  items-start mb-5">
                                <div class="flex">
                                    <div class="flex items-center h-5">
                                        <input id="terms" type="checkbox" value=""
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"
                                            required />
                                    </div>
                                    <label for="terms" class="ms-2 text-sm font-medium text-gray-900 ">
                                        <a href="#" class="text-blue-600 hover:underline ">
                                            Remember me
                                        </a></label>
                                </div>
                                <div>
                                    <label for="terms" class="ms-2 text-sm font-medium text-gray-900 ">
                                        <a href="#" class="text-gray-600 hover:underline ">
                                            Forgot Password
                                        </a></label>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <p class="text-sm font-light text-gray-500 whitespace-nowrap">
                                    Don't have an account? <a href="{{ route('register.show') }}"
                                        class="font-medium text-primary-600 hover:underline">Register here</a>
                                </p>
                                <button type="submit"
                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

</html>
