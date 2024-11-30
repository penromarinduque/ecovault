@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')


    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-300 mt-2">

        <h1 class="font-medium  text-2xl text-gray-500">Land Titles/Patented Lots</h1>
        {{-- <h1 class="font-medium  text-2xl text-gray-500">Environmental Permits and Land Records Folder</h1> --}}
        <div>

        </div>
        <!-- Unified Grid Section -->
        <div class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- Category 1 -->
            <div class="flex flex-col items-center">
                <a href="{{ route('file-manager.municipality.show', ['type' => $type, 'category' => 'agricultural']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Agricultural Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center">Agricultural</h1>
                </a>
            </div>

            <!-- Category 2 -->
            <div class="flex flex-col items-center">
                <a href="{{ route('file-manager.municipality.show', ['type' => $type, 'category' => 'residential']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Residential Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center">Residential</h1>
                </a>
            </div>

            <!-- Category 3 -->
            <div class="flex flex-col items-center">
                <a href="{{ route('file-manager.municipality.show', ['type' => $type, 'category' => 'special']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Special Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center">Special</h1>
                </a>
            </div>

            <!-- Example additional category -->
            <div class="flex flex-col items-center">
                <a href="{{ route('file-manager.land-title.show', ['type' => 'land-titles']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Land Titles Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center">Land Titles</h1>
                </a>
            </div>
        </div>
    </div>

@endsection
