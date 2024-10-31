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



        <div class="grid grid-cols-4 m-16 space-y-4 ">
            <div class="">
                <a href="Buenavista">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Buenavista</h1>
                </a>
            </div>

            <div class="">
                <a href="Boac">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Boac</h1>
                </a>
            </div>

            <div class="">
                <a href="Gasan">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Gasan</h1>
                </a>
            </div>

            <div class="">
                <a href="Mogpog">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Mogpog</h1>
                </a>
            </div>

            <div class="">
                <a href="Torrijos">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Torrijos</h1>
                </a>
            </div>

            <div class="Sta. Cruz">
                <a href="Sta-Cruz">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Sta. Cruz</h1>
                </a>
            </div>

        </div>
    </div>




@endsection
