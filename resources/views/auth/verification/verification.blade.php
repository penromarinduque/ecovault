@extends('auth.master')

@section('title', 'Verification')

@section('content')
    <div class="flex justify-center items-center ">
        <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
            <header class="mb-8">
                <h1 class="text-2xl font-bold mb-1">Gmail Verification</h1>
                <p class="text-[15px] text-slate-500">Enter the 4-digit verification code that was sent to
                    <span class="text-lg ">{{ $email }}</span>
                    account.
                </p>
            </header>
            <form id="otp-form" action="{{ route('verify.email.post') }}" method="POST">
                @csrf

                <div class="flex items-center justify-center gap-3">
                    <input type="text" name="otp[]"
                        class="otp-input w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-300 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        pattern="\d*" maxlength="1" />
                    <input type="text" name="otp[]"
                        class="otp-input w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-300 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        maxlength="1" />
                    <input type="text" name="otp[]"
                        class="otp-input w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-300 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        maxlength="1" />
                    <input type="text" name="otp[]"
                        class="otp-input w-14 h-14 text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-300 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                        maxlength="1" />
                </div>
                <div class="max-w-[260px] mx-auto mt-4">
                    <button type="submit" id="verify-button"
                        class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-gray-800 hover:bg-gray-900 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">Verify
                        Account</button>
                </div>
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
            </form>
            <div class="text-sm text-slate-500 mt-4">
                Didn't receive code?
                <button id="resend-otp-btn" class="font-medium text-slate-800 hover:text-slate-900">Resend</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('otp-form')
            const inputs = [...form.querySelectorAll('input[type=text]')]
            const submit = form.querySelector('button[type=submit]')

            const handleKeyDown = (e) => {
                if (
                    !/^[0-9]{1}$/.test(e.key) &&
                    e.key !== 'Backspace' &&
                    e.key !== 'Delete' &&
                    e.key !== 'Tab' &&
                    !e.metaKey
                ) {
                    e.preventDefault()
                }

                if (e.key === 'Backspace' || e.key === 'Delete') {
                    const index = inputs.indexOf(e.target);
                    // If current input is empty, move focus to the previous input
                    if (!e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    } else {
                        e.target.value = ''; // Clear current input value
                    }
                }
            }

            const handleInput = (e) => {
                const target = e.target;
                const index = inputs.indexOf(target);
                if (target.value) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    } else {
                        submit.focus();
                    }
                }
            }

            const handleFocus = (e) => {
                e.target.select();
            }

            const handlePaste = (e) => {
                e.preventDefault();
                const text = e.clipboardData.getData('text');
                if (!new RegExp(`^[0-9]{${inputs.length}}$`).test(text)) {
                    return;
                }
                const digits = text.split('');
                inputs.forEach((input, index) => input.value = digits[index]);
                submit.focus();
            }

            inputs.forEach((input) => {
                input.addEventListener('input', handleInput);
                input.addEventListener('keydown', handleKeyDown);
                input.addEventListener('focus', handleFocus);
                input.addEventListener('paste', handlePaste);
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const verifyButton = document.getElementById('verify-button');
            const inputs = document.querySelectorAll('.otp-input');

            if (verifyButton) {
                verifyButton.addEventListener('click', async (event) => {
                    event.preventDefault(); // Prevent default form submission

                    const otp = Array.from(inputs).map(input => input.value).join('');
                    const csrfToken = '{{ csrf_token() }}';

                    try {
                        const response = await fetch("{{ route('verify.email.post') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: JSON.stringify({
                                otp: otp.split(''), // Convert back to an array
                            }),
                        });

                        const data = await response.json();

                        if (response.ok) {
                            showToast({
                                type: 'success',
                                message: data.message || 'Verified successfully!',
                            });

                            // Redirect after a slight delay
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        } else {
                            // Display error message from the response
                            showToast({
                                type: 'danger',
                                message: data.message || 'An error occurred.',
                            });
                        }
                    } catch (error) {
                        showToast({
                            type: 'danger',
                            message: 'Something went wrong. Please try again later.',
                        });
                        console.error('Error:', error);
                    }
                });
            }
        });

        document.getElementById('resend-otp-btn').addEventListener('click', async function(e) {
            e.preventDefault();

            // Get the email from session (or provide a way to get it dynamically)
            const email = '{{ session('email') }}';
            document.getElementById('otp-form').classList.add('pointer-events-none', 'opacity-50');
            document.getElementById('form-spinner').classList.remove('hidden');
            if (!email) {
                showToast({
                    type: 'danger',
                    message: 'Email not available. You will be redirected to login.',
                });
                setTimeout(function() {
                    window.location.href = '{{ route('login.show') }}';
                }, 2000); // 2000 ms = 2 seconds
                return;
            }

            // Prepare the request data
            const data = {
                email: email
            };

            try {
                // Send the POST request to the API endpoint
                const response = await fetch("{{ route('resend.otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify(data),
                });

                // Handle the response
                if (response.ok) {
                    const result = await response.json();
                    showToast({
                        type: 'success',
                        message: result.message,
                    });
                } else {
                    const error = await response.json();
                    showToast({
                        type: 'danger',
                        message: error.message,
                    });
                }
            } catch (error) {
                console.error("Error resending OTP:", error);
                showToast({
                    type: 'danger',
                    message: 'Something went wrong. Please try again later.',
                });
            } finally {
                document.getElementById('otp-form').classList.remove('pointer-events-none', 'opacity-50');
                document.getElementById('form-spinner').classList.add('hidden');
            }
        });
    </script>
@endsection
