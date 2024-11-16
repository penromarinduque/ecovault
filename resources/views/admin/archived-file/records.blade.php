@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')


    <div class=" rounded-md text-black p-4 ">

        <!--call other popup here-->
        <x-modal.file-modal />

        @component('components.file-share.file-share', [
            'includePermit' => false,
        ])
        @endcomponent

        @component('components.file-request.file-request', [
            //Enter here for passing variable(future purposes)
        ])
        @endcomponent

        <div class="grid">
            <div id="mainTable" class="transition-opacity duration-500 ease-in-out opacity-100">
                <div class="overflow-x-auto bg-white rounded-lg p-5">
                    @component('components.forms.table', [
                        'record' => $record ?? '',
                        'type' => $type ?? '',
                        'municipality' => $municipality ?? '',
                        'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                        'isArchived' => true,
                    ])
                        <!--add something to use in the table updated by harvs-->
                    @endcomponent
                </div>
            </div>

            <div id="fileSection" class="transition-opacity duration-500 ease-in-out opacity-0 hidden">
                <div class="grid grid-cols-3 gap-4">
                    <div class="overflow-auto  rounded-lg bg-white p-5">
                        @component('components.forms.minimize-table', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record ?? '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => true,
                            'category' => $category ?? '',
                        ])
                            <!--add something to use in the table updated by harvs-->
                        @endcomponent
                    </div>

                    <div class=" p-4 col-span-2 bg-white rounded-md ">


                        @component('components.move.move-file', [])
                        @endcomponent
                        @component('components.file-upload.file-upload', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record ?? '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => true,
                            'category' => $category ?? '',
                        ])
                        @endcomponent
                        @component('components.edit.edit-file', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record ?? '',
                        ])
                        @endcomponent
                        @component('components.file-summary.file-summary', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record,
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
