@extends('auth.master')

@section('title', 'Login')

@section('content')

    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
            <div class="w-screen bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0  ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                        Login
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

                        <div class="mb-5 relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your
                                password</label>
                            <input type="password" id="password" name="password"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="••••••••" required />

                            <!-- Eye Icon Button for toggling password -->
                            <span id="togglePassword" class="absolute right-2 top-9 cursor-pointer">
                                <!-- Eye SVG (Visible Password) -->
                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>


                                <!-- Eye Slash SVG (Hidden Password) -->
                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="size-6 hidden text-gray-600"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
                        </div>

                        <div class="flex justify-between  items-start mb-5">
                            <div class="flex">
                                <div class="flex items-center h-5">
                                    <input id="terms" type="checkbox" name="remember"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" />
                                </div>
                                <label for="terms" class="ms-2 text-sm font-medium text-gray-900 ">
                                    <a href="#" class="text-blue-600 hover:underline ">
                                        Remember me
                                    </a></label>
                            </div>
                            <div>
                                <label for="terms" class="ms-2 text-sm font-medium text-gray-900 ">
                                    <a href="{{ route('password.request') }}" class="text-gray-600 hover:underline ">
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

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");
        const eyeOpenIcon = document.querySelector("#eye-open");
        const eyeClosedIcon = document.querySelector("#eye-closed");

        togglePassword.addEventListener("click", function() {
            // Toggle the password visibility
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            // Toggle the visibility of the icons
            eyeOpenIcon.classList.toggle("hidden");
            eyeClosedIcon.classList.toggle("hidden");
        });
    </script>

@endsection
