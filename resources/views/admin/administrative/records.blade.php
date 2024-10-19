@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4 ">

        <h1 class="font-bold text-2xl">Environmental Permits and Land Records Folder</h1>
        <div class="grid grid-cols-4 m-16 ">
            <div class="my-4">
                <a href="{{ route('file-manager.municipality.show', ['type' => 'tree-cutting-permits']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Memoranda</h1>
                </a>
            </div>

            <div class="my-4">
                <a href="{{ route('file-manager.municipality.show', ['type' => 'tree-plantation']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Letters</h1>
                </a>
            </div>

            <div class="my-4">
                <a href="{{ route('file-manager.municipality.show', ['type' => 'tree-transport-permits']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Special Orders</h1>
                </a>
            </div>

            <div class="my-4 items-center fkex">
                <a href="{{ route('file-manager.municipality.show', ['type' => 'chainsaw-registration']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Reports</h1>
                </a>
            </div>


        </div>
    </div>
@endsection
