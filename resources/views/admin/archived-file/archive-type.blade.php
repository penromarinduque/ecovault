@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-300 mt-2">
        <!-- Header -->
        <h1 class="font-medium  text-2xl text-gray-500">Environmental Permits and Land Records Folder</h1>

        <!-- Grid Container -->
        <div class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- Archived File Manager -->
            <div class="flex flex-col items-center">
                <a href="{{ route('archived-file.file-manager.show', ['archivedType' => 'file-manager']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Archived File Manager" class="w-24 mb-2">
                    <h2 class="w-[120px] text-gray-700">Archived File Manager</h2>
                </a>
            </div>

            <!-- Archived Administrative Documents -->
            <div class="flex flex-col items-center">
                <a href="{{ route('archived.administrative.show', ['archivedType' => 'administrative-document']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Archived Administrative Documents"
                        class="w-24 mb-2">
                    <h2 class="w-[120px] text-gray-700">Archived Administrative</h2>
                </a>
            </div>
        </div>
    </div>

@endsection
