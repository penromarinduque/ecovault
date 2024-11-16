@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    @component('components.bread-crumb.archive-bread-crumb', [])
    @endcomponent
    <div class="h-[600px] rounded-md text-black p-4">
        <h1 class="font-bold text-2xl text-center">Environmental Permits and Land Records Folder</h1>

        <div class="grid grid-cols-4 gap-4 m-4"> <!-- Use gap for consistent spacing -->
            <!-- Each folder item -->
            <div class="my-4 flex flex-col items-center"> <!-- Center items -->
                <a href="{{ route('archived.file-manager.municipality.show', ['archivedType' => $archivedType, 'type' => 'tree-cutting-permits']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Tree Cutting Permits" class="w-24 mb-2">
                    <!-- Added margin-bottom for spacing -->
                    <h2 class="w-[120px]">Tree Cutting Permits</h2>
                </a>
            </div>

            <div class="my-4 flex flex-col items-center">
                <a href="{{ route('archived.file-manager.municipality.show', ['archivedType' => $archivedType, 'type' => 'tree-plantation']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Tree Plantation" class="w-24 mb-2">
                    <h2 class="w-[120px]">Tree Plantation</h2>
                </a>
            </div>

            <div class="my-4 flex flex-col items-center">
                <a href="{{ route('archived.file-manager.municipality.show', ['archivedType' => $archivedType, 'type' => 'tree-transport-permits']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Tree Transport Permits" class="w-24 mb-2">
                    <h2 class="w-[120px]">Tree Transport Permits</h2>
                </a>
            </div>

            <div class="my-4 flex flex-col items-center">
                <a href="{{ route('archived.file-manager.municipality.show', ['archivedType' => $archivedType, 'type' => 'chainsaw-registration']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Chainsaw Registration" class="w-24 mb-2">
                    <h2 class="w-[120px]">Chainsaw Registration</h2>
                </a>
            </div>

            <div class="my-4 flex flex-col items-center">
                <a href="{{ route('archived.file-manager.land-title.show', ['archivedType' => $archivedType, 'type' => 'land-titles']) }}"
                    class="text-center">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="Land Titles/ Patented Lots" class="w-24 mb-2">
                    <h2 class="w-[120px]">Land Titles/ Patented Lots</h2>
                </a>
            </div>
        </div>
    </div>

@endsection
