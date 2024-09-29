@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4 ">
        <h1 class="font-bold text-2xl my-2">Land Titles/Patented Lots</h1>
        <h1 class="font-bold text-xl">Environmental Permits and Land Records Folder</h1>
        <div class="grid grid-cols-3 m-16 ">
            <div class="">
                <a href="{{ route('file-manager.municipality.with-category.show', ['type' => $type, 'category' => 'agricultural']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Agricultural</h1>
                </a>
            </div>
            
            <div class="">
                <a href="{{ route('file-manager.municipality.with-category.show', ['type' => $type, 'category' => 'residential']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Residential</h1>
                </a>
            </div>
            
            <div class="">
                <a href="{{ route('file-manager.municipality.with-category.show', ['type' => $type, 'category' => 'special']) }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Special</h1>
                </a>
            </div>
        </div>
    </div>
   
   
    

@endsection
