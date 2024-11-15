@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="h-[600px] rounded-md text-black p-4 ">

        <h1 class="font-bold text-2xl">Environmental Permits and Land Records Folder</h1>
        <div class="grid grid-cols-4 m-16 ">
            <div class="my-4">
                <a href="{{ route('archived.administrative.record.show', ['record' => 'memoranda']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Memoranda</h1>
                </a>
            </div>

            <div class="my-4">
                <a href="{{ route('archived.administrative.record.show', ['record' => 'letters']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Letters</h1>
                </a>
            </div>

            <div class="my-4">
                <a href="{{ route('archived.administrative.record.show', ['record' => 'special-orders']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Special Orders</h1>
                </a>
            </div>

            <div class="my-4 items-center fkex">
                <a href="{{ route('archived.administrative.record.show', ['record' => 'reports']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Reports</h1>
                </a>
            </div>


        </div>
    </div>
@endsection
