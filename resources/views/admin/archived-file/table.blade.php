@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@section('content')

    <div class="bg-slate-200 overflow-auto rounded-md text-black p-4">

        <div>
            <nav aria-label="Breadcrumb">
                <ol class="flex space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('file-manager.show') }}"><span class=""> File Manager </span></a></li>
                    <li><span class="text-gray-400"> &gt; </span></li>
                    <li><a>{{ ucwords(str_replace('-', ' ', $type)) }}</a></li>
                    @if (isset($category))
                        <li><span class="text-gray-400"> &gt; </span></li>
                        <li><a>{{ ucwords(str_replace('-', ' ', $category)) }}</a></li>
                    @endif
                    <li><span class="text-gray-400"> &gt; </span></li>
                    <li><a href="{{ route('file-manager.municipality.show', $type) }}">Municipality</a></li>
                    <li><span class="text-gray-400"> &gt; </span></li>
                    <li><a class="font-bold">{{ $municipality }}</a></li>
                </ol>
            </nav>

            <div class="my-4 space-x-3">
                <x-button id="uploadBtn" label="Upload File" type="submit" style="primary" />
                <x-button id="" label="Create a Folder" style="secondary" />
            </div>
        </div>
        <!-- call other pop up using x-component-->
        <x-modal.file-modal />
        <!-- file sharing-->
        @component('components.file-share.file-share', [
            'includePermit' => true,
        ])
        @endcomponent
        @component('components.file-request.file-request', [
            //Enter here for passing variable(future purposes)
        ])
        @endcomponent

        <div class="grid">
            <div id="mainTable" class="transition-opacity duration-500 ease-in-out opacity-100">
                <div class="overflow-x-auto bg-white rounded-lg p-5">
                    <!-- load the table-->
                    @component('components.forms.table', [
                        'type' => $type,
                        'municipality' => $municipality,
                        'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                        'isArchived' => true,
                        'category' => $category ?? '',
                    ])
                        <!--add something to use in the table updated by harvs-->
                    @endcomponent
                </div>

            </div>

            <div id="fileSection" class="transition-opacity duration-500 ease-in-out opacity-0 pointer-events-none hidden">
                <div class="grid grid-cols-3 gap-4">
                    <div class="overflow-auto  rounded-lg bg-white p-5">
                        <table id="minimizeTable" class="">
                            <tbody>
                                <!-- Minimize table content goes here -->
                            </tbody>
                        </table>
                    </div>

                    <div class=" p-4 col-span-2 bg-white rounded-md ">

                        @component('components.move.move-file', [])
                        @endcomponent

                        @component('components.file-upload.file-upload', [
                            'type' => $type,
                            'municipality' => $municipality,
                            'record' => '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => true,
                            'category' => $category ?? '',
                        ])
                        @endcomponent

                        @component('components.edit.edit-file', [
                            'type' => $type,
                            'municipality' => $municipality,
                            'record' => '',
                        ])
                        @endcomponent
                        @component('components.file-summary.file-summary', [
                            'type' => $type,
                            'municipality' => $municipality,
                            'record' => '',
                        ])
                        @endcomponent

                        <div id="toast"
                            class="hidden fixed z-[90] right-0 bottom-0 m-8 bg-red-500 text-white p-4 rounded-lg shadow-lg transition-opacity duration-300 ">
                            <div class="flex justify-between items-center">
                                <p id="toast-message" class="mr-4"></p>
                                <button id="toast-close" class="text-white focus:outline-none hover:text-gray-200">
                                    <i class='bx bx-x bx-md'></i>
                                </button>
                            </div>
                            <div id="toast-timer" class="w-full h-1 bg-green-300 mt-2"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('admin.file-manager.component.js')
@endsection
