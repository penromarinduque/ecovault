@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="overflow-auto rounded-md text-black p-4">


        <div class="w-full flex justify-between {{ Auth::user()->isAdmin ? '' : 'hidden' }}">
            <div class="space-x-3 mb-4">
                <x-button id="uploadBtn" class="toggle-btn" data-toggle-target="upload" aria-controls="section-upload"
                    data-role="upload" aria-expanded="false" label="Upload File" type="button" style="primary" />

                <button id='add-folder-btn' data-modal-target="add-folder-modal" data-modal-toggle="add-folder-modal"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                    Create Folder
                </button>
            </div>
            <div class="mb-4 space-x-3">
                <a type="button" href="{{ route('client.records.show') }}"
                    class="text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg  text-center inline-flex items-center text-sm px-5 py-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                        <path fill-rule="evenodd"
                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                            clip-rule="evenodd" />
                        <path
                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>

                    Clients
                </a>
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

            @component('components.create-folder.create-folder', [
                'type' => $type ?? '',
                'municipality' => $municipality ?? '',
            ])
            @endcomponent


            <div id="table-container">
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
            <div id="section-container" class="hidden">
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

                    <div id="section-animation" class="p-4 col-span-2 bg-white rounded-md border border-gray-300 shadow-md">
                        {{-- this for upload --}}
                        <div id="move-section" class="section hidden" role="region" aria-labelledby="section-move-title">
                            @component('components.move.move-file', [
                                'type' => $type ?? '',
                                'municipality' => $municipality ?? '',
                                'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                                'isArchived' => false,
                                'category' => $category ?? '',
                            ])
                            @endcomponent
                        </div>

                        <div id="upload-section" class="section hidden" role="region"
                            aria-labelledby="section-upload-title">
                            @component('components.file-upload.file-upload', [
                                'type' => $type ?? '',
                                'municipality' => $municipality ?? '',
                                'record' => $record ?? '',
                                'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                                'isArchived' => false,
                                'category' => $category ?? '',
                            ])
                            @endcomponent
                        </div>

                        <div id="edit-section" class="section hidden" role="region" aria-labelledby="section-edit-title">
                            @component('components.edit.edit-file', [
                                'type' => $type ?? '',
                                'municipality' => $municipality ?? '',
                                'record' => $record ?? '',
                                'authId' => Auth::user()->id,
                                'includePermit' => true,
                            ])
                            @endcomponent
                        </div>

                        <div id="summary-section" class="section hidden" role="region"
                            aria-labelledby="section-summary-title">
                            @component('components.file-summary.file-summary', [
                                'type' => $type ?? '',
                                'record' => $record ?? '',
                                'includePermit' => true,
                            ])
                            @endcomponent
                        </div>

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
