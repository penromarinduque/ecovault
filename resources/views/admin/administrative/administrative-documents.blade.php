@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-gray-300 mt-2">
        <!-- Header -->
        <h1 class="font-medium text-2xl text-gray-500">Administrative Documents</h1>

        <!-- Grid Container -->
        <div class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- Tree Cutting Permits -->
            <!-- Administrative Folders -->
            <div class="flex flex-col items-center">
                <a href="{{ route('administrative.record.show', ['record' => 'memoranda']) }}" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Memoranda Folder" class="w-24 mb-2">
                    <h2 class="w-[120px]">Memoranda</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="{{ route('administrative.record.show', ['record' => 'letters']) }}" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Letters Folder" class="w-24 mb-2">
                    <h2 class="w-[120px]">Letters</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="{{ route('administrative.record.show', ['record' => 'special-orders']) }}" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Special Orders Folder" class="w-24 mb-2">
                    <h2 class="w-[120px]">Special Orders</h2>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <a href="{{ route('administrative.record.show', ['record' => 'reports']) }}" class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Reports Folder" class="w-24 mb-2">
                    <h2 class="w-[120px]">Reports</h2>
                </a>
            </div>
        </div>
    </div>

@endsection
