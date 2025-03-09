@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-gray-300 mt-2">
        {{-- <h1 class="font-medium text-2xl text-gray-500 mb-4">Land Titles/Patented Lots</h1> --}}
        <h1 class="font-medium  text-2xl text-gray-500">Land Titles/Patented Lots</h1>

        <!-- Unified Grid Section -->
        <div class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- Category 1 -->
            <div class="flex flex-col items-center">
                <a
                    href="{{ route('archived-file.file-manager.municipality.show', ['type' => $type, 'category' => 'agricultural']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Agricultural Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center truncate">Agricultural Free Patent</h1>
                </a>
            </div>

            <!-- Category 2 -->
            <div class="flex flex-col items-center">
                <a
                    href="{{ route('archived-file.file-manager.municipality.show', ['type' => $type, 'category' => 'residential']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Residential Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center truncate">Residential Free Patent</h1>
                </a>
            </div>

            <!-- Category 3 -->
            <div class="flex flex-col items-center">
                <a
                    href="{{ route('archived-file.file-manager.municipality.show', ['type' => $type, 'category' => 'special']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Special Folder" class="w-24 mb-2">
                    <h1 class="w-[120px] text-center truncate">Special Free Patent</h1>
                </a>
            </div>

         
        </div>
    </div>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let params = new URLSearchParams(window.location.search);

        if (params.toString()) {
            localStorage.setItem("savedQueryParams", params.toString());
        }

        window.addEventListener("popstate", function () {
            let savedParams = localStorage.getItem("savedQueryParams");
            if (savedParams) {
                window.location.href = window.location.pathname + "?" + savedParams;
            }
        });
    });
</script>