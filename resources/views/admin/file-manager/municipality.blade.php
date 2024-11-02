@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4 ">


        <nav aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <!-- Always show the type -->
                <li>
                    <span class=""> File Manager </span>
                </li>
                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a>{{ ucwords(str_replace('-', ' ', $type)) }}</a>
                </li>

                <!-- Show the category if it exists -->
                @if (isset($category))
                    <li>
                        <span class="text-gray-400"> &gt; </span>
                    </li>
                    <li>
                        <a>{{ ucwords(str_replace('-', ' ', $category)) }}</a>
                    </li>
                @endif

                <!-- Municipality is always the last breadcrumb item -->
                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a class="font-bold">Municipality</a>
                </li>
            </ol>
        </nav>



        <div class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-medium">
            <!-- Use gap instead of space-y-4 for even spacing -->
            <div class="flex flex-col items-center"> <!-- Flexbox for centering -->
                <a href="Buenavista" class="text-center"> <!-- Centering text under image -->
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Buenavista" class="w-24 mb-2">
                    <!-- Add margin-bottom for spacing -->
                    <h2 class="w-[120px]">Buenavista</h2> <!-- Changed to h2 for semantic structure -->
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="Boac" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Boac" class="w-24 mb-2">
                    <h2 class="w-[120px]">Boac</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="Gasan" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Gasan" class="w-24 mb-2">
                    <h2 class="w-[120px]">Gasan</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="Mogpog" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Mogpog" class="w-24 mb-2">
                    <h2 class="w-[120px]">Mogpog</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="Torrijos" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Torrijos" class="w-24 mb-2">
                    <h2 class="w-[120px]">Torrijos</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="Sta-Cruz" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Sta. Cruz" class="w-24 mb-2">
                    <h2 class="w-[120px]">Sta. Cruz</h2>
                </a>
            </div>
        </div>

    </div>




@endsection
