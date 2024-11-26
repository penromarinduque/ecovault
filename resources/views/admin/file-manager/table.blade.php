@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="overflow-auto rounded-md text-black p-4">

        <div class="w-full flex">
            <div class="space-x-3 mb-4">
                <x-button id="uploadBtn" label="Upload File" type="submit" style="primary" />
                <button id='add-folder-btn' data-modal-target="add-folder-modal" data-modal-toggle="add-folder-modal"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                    Create Folder
                </button>
            </div>
        </div>

        <!-- call other pop up using x-component-->
        <x-modal.file-modal />
        @component('components.addfile.add-file', [
            'type' => $type ?? '',
            'municipality' => $municipality ?? '',
            'isArchived' => false,
        ])
        @endcomponent
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

            @component('components.folders')
            @endcomponent


            <div id="mainTable" class="duration-500 ease-in-out opacity-100 ">
                <div
                    class="overflow-x-auto bg-white rounded-md p-5 shadow-md border border-gray-300 min-h-[calc(80vh-80px)]">
                    <!-- load the table-->
                    @component('components.forms.table', [
                        'type' => $type ?? '',
                        'municipality' => $municipality ?? '',
                        'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                        'isArchived' => false,
                        'category' => $category ?? '',
                    ])
                        <!--add something to use in the table updated by harvs-->
                    @endcomponent
                </div>
            </div>
            <div id="fileSection" class="transition-opacity duration-500 ease-in-out opacity-0 pointer-events-none hidden">
                <div class="grid grid-cols-3 gap-4 ">
                    <div class="overflow-y-auto rounded-md bg-white p-5 border border-gray-300 shadow-md">
                        @component('components.forms.minimize-table', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => false,
                            'category' => $category ?? '',
                        ])
                            <!--add something to use in the table updated by harvs-->
                        @endcomponent
                        <!-- minimize table here-->
                    </div>

                    <div class=" p-4 col-span-2 bg-white rounded-md border border-gray-300 shadow-md animate-slideIn">
                        {{-- this for upload --}}
                        @component('components.move.move-file', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => false,
                            'category' => $category ?? '',
                        ])
                        @endcomponent

                        @component('components.file-upload.file-upload', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record ?? '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => false,
                            'category' => $category ?? '',
                        ])
                        @endcomponent

                        @component('components.edit.edit-file', [
                            'type' => $type ?? '',
                            'municipality' => $municipality ?? '',
                            'record' => $record ?? '',
                            'authId' => Auth::user()->id,
                            'includePermit' => true,
                        ])
                        @endcomponent

                        @component('components.file-summary.file-summary', [
                            'type' => $type ?? '',
                            'record' => $record ?? '',
                            'includePermit' => true,
                        ])
                        @endcomponent
                        <!-- for showing the specification details-->

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
