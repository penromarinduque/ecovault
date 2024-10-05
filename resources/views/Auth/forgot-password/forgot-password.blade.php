@extends('auth.master')

@section('title', 'Reset Password')

@section('content')
    <section class="bg-gray-50 ">
        <div class="flex flex-col items-center justify-center px-6 py-8   lg:py-0">
            <div class="w-full p-6 bg-white rounded-lg shadow  md:mt-0 sm:max-w-md   sm:p-8">
                <h1 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                    Forgot your password?
                </h1>
                <p class="font-light text-gray-500 ">Don't fret! Just type in your email and we will send
                    you a code to reset your password!</p>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your
                            email</label>
                        <input value="{{ old('email') }}" type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Enter your email" required="">
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
                        class="w-full text-white bg-gray-800 hover:bg-gray-900  bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Send
                        Password Reset Link</button>
                </form>
            </div>
        </div>
    </section>
    {{-- @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
@endsection
