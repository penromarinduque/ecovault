@extends('layouts.user.master')

@section('title', 'PENRO Archiving System')



@section('content')
    <img src="{{ asset('images/denr-home.jpg') }}" class="fixed inset-0 bg-cover w-full h-full -z-10" alt="Background Image">
    <section class="bg-transparent p-10">
        <div class="grid max-w-screen-xl mx-auto lg:gap-8 xl:gap-8 lg:py-16 lg:grid-cols-12">

            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('images/logo.png') }}" class="" alt="PENRO-logo">
            </div>

            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl text-white mb-4 text-5xl font-extrabold tracking-tight leading-none">
                    Welcome to Document Security and Digital Archiving System.</h1>
                <h1 class="max-w-2xl text-slate-300 mb-4 text-4xl font-extrabold tracking-tight leading-none">
                    PENRO-Boac Marinduque</h1>
                <p class="max-w-2xl mb-6 font-md text-gray-300 lg:mb-8 md:text-lg lg:text-xl">
                    Efficient document management system provides tailored solutions, enhancing workflow seamlessly</p>
                <a href="#"
                    class="transition ease-in-out delay-150 hover:scale-110  hover:-translate-y-1 inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white border bg-primary-700 border-gray-300 rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-gray-100">
                    Get started
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>

            </div>
        </div>
    </section>
@endsection
