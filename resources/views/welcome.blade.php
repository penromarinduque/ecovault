@extends('layouts.user.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="grid grid-flow-col m-14 gap-5">

        <div>
            <div class=""><img src="{{ asset('images/denr-home.jpg') }}"
                    class="w-[720px] h-[380px] drop-shadow-md rounded-lg " alt="" srcset=""></div>
        </div>

        <div class="space-y-3 m-4 mt-20">
            <h1 class="font-bold text-3xl w-10/12">Welcome to Document Security and Digital Archiving System</h1>
            <p class="text-xl font-medium">PENRO-Boac Marinduque</p>
            <p class="w-9/12">Efficient document management system provides tailored solutions, enhancing workflow seamlessly
            </p>
            <div>
                <a href="{{ route('login.show') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Get
                    Started</a>
            </div>

        </div>

    </div>
@endsection
