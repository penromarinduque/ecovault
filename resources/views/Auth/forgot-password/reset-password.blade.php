@extends('auth.master')

@section('title', 'Reset Password')

@section('content')
    {{-- @if (session('status'))
        <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4">
            {{ session('status') }}
        </div>
    @endif --}}
    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8   lg:py-0">
            <div class="w-full p-6 bg-white rounded-lg shadow  md:mt-0 sm:max-w-md   sm:p-8">
                <h1 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                    Change Password
                </h1>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                            email</label>
                        <input value="{{ old('email', $email) }}" type="email" name="email" id="email" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Enter your email" required="">
                        @error('email')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5 relative">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">New Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required="">
                        @error('password')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror

                        <!-- Eye Icon Button for New Password -->
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

                    <div class="mb-5 relative">
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                            password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required="">

                        <!-- Eye Icon Button for Confirm Password -->
                        <span id="toggleConfirmPassword" class="absolute right-2 top-9 cursor-pointer">
                            <!-- Eye SVG (Visible Password) -->
                            <svg id="eye-confirm-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <!-- Eye Slash SVG (Hidden Password) -->
                            <svg id="eye-confirm-closed" xmlns="http://www.w3.org/2000/svg"
                                class="size-6 hidden text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex items-start">
                        <div class="ml-3 text-sm">
                            <a href="{{ route('login.show') }}"
                                class="text-blue-800 hover:text-blue-900 font-medium text-primary-600 hover:underline">
                                Back to login
                            </a>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-gray-800 hover:bg-gray-900  bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Reset Password</button>
                </form>
            </div>
        </div>
    </section>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeOpen = document.querySelector('#eye-open');
        const eyeClosed = document.querySelector('#eye-closed');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });


        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#password_confirmation');
        const eyeConfirmOpen = document.querySelector('#eye-confirm-open');
        const eyeConfirmClosed = document.querySelector('#eye-confirm-closed');

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            eyeConfirmOpen.classList.toggle('hidden');
            eyeConfirmClosed.classList.toggle('hidden');
        });
    </script>
@endsection
