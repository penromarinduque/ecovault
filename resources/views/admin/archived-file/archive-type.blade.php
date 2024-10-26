@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4 ">

        <h1 class="font-bold text-2xl">Environmental Permits and Land Records Folder</h1>
        <div class="grid grid-cols-4 m-16 ">
            <div class="my-4">

                <a href="{{ route('archived-file.file-manager.show') }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Archived Fle Manager</h1>
                </a>
            </div>

            {{-- {{ route('archive.administrative-report.show', ['archiveType' => 'administrative']) }} --}}
            <div class="my-4">
                <a href="{{ route('archived.administrative.show') }}">
                    <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24">
                    <h1 class="w-[120px]">Archived Administrative Documents</h1>
                </a>
            </div>



        </div>
    </div>
@endsection
