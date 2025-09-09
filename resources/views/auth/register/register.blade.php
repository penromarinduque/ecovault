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
                    <form id="register-form" class="space-y-4 md:space-y-6 " method="POST" action="{{ route('user.post') }}">
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
                            <div id="password-requirements"
                                class="absolute top-15 left-0 hidden bg-gray-100 border border-gray-300 rounded p-2 mt-2 w-full z-50">
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

                        <div class="mb-5 relative">
                            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                                password</label>
                            <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required="">
                            <span id="togglePasswordConfirmation" class="absolute right-2 top-9 cursor-pointer">
                                <svg id="eye-open-confirmation" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg id="eye-closed-confirmation" xmlns="http://www.w3.org/2000/svg"
                                    class="size-6 hidden text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
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
                    <div id="form-spinner"
                        class="flex items-center hidden justify-center min-h-screen absolute z-[60] inset-24">
                        <div role="status" class="text-center">
                            <svg aria-hidden="true"
                                class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        // Function to toggle password visibility
        function setupPasswordToggle(inputId, toggleButtonId, eyeOpenId, eyeClosedId) {
            const inputField = document.getElementById(inputId);
            const toggleButton = document.getElementById(toggleButtonId);
            const eyeOpen = document.getElementById(eyeOpenId);
            const eyeClosed = document.getElementById(eyeClosedId);

            toggleButton.addEventListener('click', () => {
                const isPassword = inputField.type === 'password';
                inputField.type = isPassword ? 'text' : 'password';

                // Toggle SVG visibility
                eyeOpen.classList.toggle('hidden', !isPassword);
                eyeClosed.classList.toggle('hidden', isPassword);
            });
        }

        // Initialize toggle for both password fields
        setupPasswordToggle('password', 'togglePassword', 'eye-open', 'eye-closed');
        setupPasswordToggle('confirm-password', 'togglePasswordConfirmation', 'eye-open-confirmation',
            'eye-closed-confirmation');




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
        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent default form submission
            const form = document.getElementById('register-form');
            const formData = new FormData(this);
            const csrfToken = '{{ csrf_token() }}';
            form.classList.add('pointer-events-none', 'opacity-50');
            document.getElementById('form-spinner').classList.remove('hidden');
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // Tell Laravel we want a JSON response
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    // Display success message
                    // showToast({
                    //     type: 'success',
                    //     message: data.message,
                    // });

                    // Redirect to the verification page
                    window.location.href = data.redirect;
                } else if (data.errors) {
                    // Handle validation errors
                    Object.values(data.errors).flat().forEach(message => {
                        showToast({
                            type: 'danger',
                            message: message,
                        });
                    });

                } else {
                    // Handle general errors
                    showToast({
                        type: 'danger',
                        message: data.message || 'An unexpected error occurred.',
                    });

                }
            } catch (error) {
                // Handle unexpected errors (e.g., network issues)
                console.error('Error:', error);
                showToast({
                    type: 'danger',
                    message: 'An unexpected error occurred. Please try again later.',
                });
                form.classList.remove('pointer-events-none');
            } finally {
                // Always remove the pointer-events-none class
                form.classList.remove('pointer-events-none', 'opacity-50');
                document.getElementById('form-spinner').classList.add('hidden');
            }
        });
    </script>

@endsection
