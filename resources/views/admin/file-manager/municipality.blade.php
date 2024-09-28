@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-600 h-[600px] rounded-md text-black p-4 ">
        
        <h1 class="font-bold text-2xl">Environmental Permits and Land Records Folder</h1>
        <div class="grid grid-cols-4 m-16 space-y-4 ">
            <div class="">
                <a href="link-to-permits">
                    <img src="{{asset('images/admin/folder.png')}}" alt="" class="w-24">
                    <h1 class="w-[120px]">Buenavista</h1>
                </a>
            </div>
            
            <div class="">
                <a href="link-to-plantation">
                    <img src="{{asset('images/admin/folder.png')}}" alt="" class="w-24">
                    <h1 class="w-[120px]">Boac</h1>
                </a>
            </div>
            
            <div class="">
                <a href="link-to-transport-permits">
                    <img src="{{asset('images/admin/folder.png')}}" alt="" class="w-24">
                    <h1 class="w-[120px]">Gasan</h1>
                </a>
            </div>
            
            <div class="">
                <a href="link-to-registration">
                    <img src="{{asset('images/admin/folder.png')}}" alt="" class="w-24">
                    <h1 class="w-[120px]">Mogpog</h1>
                </a>
            </div>
            
            <div class="">
                <a href="link-to-land-titles">
                    <img src="{{asset('images/admin/folder.png')}}" alt="" class="w-24">
                    <h1 class="w-[120px]">Torrijos</h1>
                </a>
            </div>
            
        </div>
    </div>
   
   
    

@endsection




        
       