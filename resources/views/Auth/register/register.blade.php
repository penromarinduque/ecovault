@extends('auth.master')

@section('title', 'Register')

@section('content')
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 mb-6">
            <div class="w-screen bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create Account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('user.post') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Name" required="">
                        </div>
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="user@gmail.com" required="">
                        </div>
                        <div class="mb-5">
                            <label for="employee_id" class="block mb-2 text-sm font-medium text-gray-900">Employee
                                ID</label>
                            <input type="text" name="employee_id" id="employee_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="ID" maxlength="25" required="">
                        </div>
                        <div class="mb-5 relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="">
                            <div id="password-requirements"
                                class="absolute top-15 left-0 hidden bg-gray-100 border border-gray-300 rounded p-2 mt-2 w-full">
                                <h2 class="mb-2 text-lg font-semibold text-gray-900">Password requirements:</h2>
                                <ul class="max-w-md space-y-1 text-gray-500 list-inside">
                                    <li class="flex items-center" id="char-length">
                                        <svg class="w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                        </svg>
                                        At least 8 characters
                                    </li>
                                    <li class="flex items-center" id="uppercase">
                                        <svg class="w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                        </svg>
                                        At least one uppercase character
                                    </li>
                                    <li class="flex items-center" id="special-char">
                                        <svg class="w-3.5 h-3.5 me-2 text-gray-500 flex-shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                        </svg>
                                        At least one special character, e.g., ! @ # ?
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                                password</label>
                            <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="">
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light text-gray-500 whitespace-nowrap">
                                Already have an account? <a href="{{ route('login.show') }}"
                                    class="font-medium text-primary-600 hover:underline">Login here</a>
                            </p>
                            <button type="submit"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordRequirements = document.getElementById('password-requirements');
        const charLength = document.getElementById('char-length');
        const uppercase = document.getElementById('uppercase');
        const specialChar = document.getElementById('special-char');

        // Show password requirements on hover
        passwordInput.addEventListener('focus', () => {
            passwordRequirements.classList.remove('hidden');
        });

        passwordInput.addEventListener('blur', () => {
            passwordRequirements.classList.add('hidden');
        });

        // Password validation
        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;

            // Check if password length is at least 8 characters
            if (value.length >= 8) {
                charLength.classList.remove('text-gray-500');
                charLength.classList.add('text-green-500');
                charLength.querySelector('svg').classList.add('text-green-500'); // Update SVG color
            } else {
                charLength.classList.remove('text-green-500');
                charLength.classList.add('text-gray-500');
                charLength.querySelector('svg').classList.remove('text-green-500'); // Reset SVG color
            }

            // Check if password contains at least one uppercase letter
            if (/[A-Z]/.test(value)) {
                uppercase.classList.remove('text-gray-500');
                uppercase.classList.add('text-green-500');
                uppercase.querySelector('svg').classList.add('text-green-500'); // Update SVG color
            } else {
                uppercase.classList.remove('text-green-500');
                uppercase.classList.add('text-gray-500');
                uppercase.querySelector('svg').classList.remove('text-green-500'); // Reset SVG color
            }

            // Check if password contains at least one special character
            if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                specialChar.classList.remove('text-gray-500');
                specialChar.classList.add('text-green-500');
                specialChar.querySelector('svg').classList.add('text-green-500'); // Update SVG color
            } else {
                specialChar.classList.remove('text-green-500');
                specialChar.classList.add('text-gray-500');
                specialChar.querySelector('svg').classList.remove('text-green-500'); // Reset SVG color
            }
        });
    </script>

@endsection
