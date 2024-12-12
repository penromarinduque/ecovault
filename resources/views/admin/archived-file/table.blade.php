@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="overflow-auto rounded-md text-black p-4">


        <div class="w-full flex {{ Auth::user()->isAdmin ? '' : 'hidden' }}">
            <div class="space-x-3 mb-4">
                <x-button id="uploadBtn" class="toggle-btn" data-toggle-target="upload" aria-controls="section-upload"
                    data-role="upload" aria-expanded="false" label="Upload File" type="button" style="primary" />

                <button id='add-folder-btn' data-modal-target="add-folder-modal" data-modal-toggle="add-folder-modal"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                    Create Folder
                </button>
            </div>
        </div>

        <form class="max-w-md mx-auto">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Mockups, Logos..." required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

        <!-- call other pop up using x-component-->
        <x-modal.file-modal />
        @component('components.addfile.add-file', [
            'type' => $type ?? '',
            'municipality' => $municipality ?? '',
            'isArchived' => true,
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
                        'isArchived' => true,
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
                            'isArchived' => true,
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
                                'isArchived' => true,
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
                                'isArchived' => true,
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
