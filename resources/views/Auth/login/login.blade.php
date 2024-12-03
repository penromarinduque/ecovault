@extends('auth.master')

@section('title', 'Login')

@section('content')

    <section class="bg-gray-50 flex items-center">
        <div class="flex flex-col items-center justify-center w-full px-6 py-8 mx-auto lg:py-0">
            <div class="w-screen bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Login
                    </h1>
                    <form id="login-form" class="space-y-4 md:space-y-6" action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input type="email" id="email" name="email"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="user@gmail.com" required />
                        </div>

                        <div class="mb-5 relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Your password</label>
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

                        <div class="flex justify-between items-start mb-5">
                            <div class="flex">
                                <div class="flex items-center h-5">
                                    <input id="remember" type="checkbox" name="remember"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" />
                                </div>
                                <label for="remember" class="ms-2 text-sm font-medium text-blue-600 hover:underline">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <label for="terms" class="ms-2 text-sm font-medium text-gray-900">
                                    <a href="{{ route('password.request') }}" class="text-gray-600 hover:underline">
                                        Forgot Password
                                    </a>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light text-gray-500 whitespace-nowrap">
                                Don't have an account? <a href="{{ route('register.show') }}"
                                    class="font-medium text-primary-600 hover:underline">Register here</a>
                            </p>
                            <button type="button" id="login-button"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Login</button>
                        </div>
                    </form>
                    <div id="form-spinner"
                        class="flex items-center hidden justify-center min-h-screen absolute z-[60] inset-20">
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
        document.getElementById('login-button').addEventListener('click', async function(e) {
            e.preventDefault(); // Prevent default form submission
            const csrfToken = '{{ csrf_token() }}';
            const form = document.getElementById('login-form');
            const formData = new FormData(document.getElementById('login-form'));
            form.classList.add('pointer-events-none', 'opacity-50');
            // document.getElementById('form-spinner').classList.remove('hidden');

            try {
                const response = await fetch('/login/auth', {
                    method: 'POST', // Corrected method
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // Corrected headers
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const data = await response.json(); // Corrected variable name

                if (response.ok && data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    // Check if there are error messages
                    if (data.errors) {
                        // Loop through each error message
                        Object.values(data.errors).flat().forEach(message => {
                            showToast({
                                type: 'danger',
                                message: message,
                            });
                        });
                    } else {
                        // If there's a general error message
                        showToast({
                            type: 'danger',
                            message: data.message,
                        });
                    }
                }

            } catch (error) { // Added the error argument to catch block
                console.error('Error:', error);
                showToast({
                    type: 'danger',
                    message: 'An unexpected error occurred. Please try again later.',
                });
            } finally {
                form.classList.remove('pointer-events-none', 'opacity-50');
                //document.getElementById('form-spinner').classList.add('hidden');
            }
        });
    </script>

@endsection
