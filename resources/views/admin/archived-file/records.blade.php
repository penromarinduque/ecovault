@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="overflow-auto rounded-md text-black p-4">

        <div class="w-full">
            <div class="space-x-3 mb-4">
                <x-button id="uploadBtn" class="toggle-btn" data-toggle-target="upload" aria-controls="section-upload"
                    aria-expanded="false" label="Upload File" type="button" style="primary" />
               
            </div>
        </div>

        <!--call other popup here-->
        <x-modal.file-modal />



        @component('components.addfile.add-file', [
            'record' => $record ?? '',
            'isArchived' => true,
        ])
        @endcomponent


        @component('components.file-share.file-share', [
            'includePermit' => false,
        ])
        @endcomponent

        @component('components.file-request.file-request', [
            //Enter here for passing variable(future purposes)
        ])
        @endcomponent

        <div class="grid">


            @component('components.file-view', [
                'record' => $record,
                'type' => '',
                'municipality' => '',
                'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                'isArchived' => true,
            ])
                <!--add something to use in the table updated by harvs-->
            @endcomponent

            <div id="table-container">
                <div class="overflow-x-auto bg-white rounded-md p-5 shadow-md border border-gray-300 h-[calc(80vh-100px)]">
                    @component('components.forms.table', [
                        'record' => $record,
                        'type' => '',
                        'municipality' => '',
                        'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                        'isArchived' => true,
                    ])
                        <!--add something to use in the table updated by harvs-->
                    @endcomponent
                </div>
            </div>

            <div id="section-container" class="hidden">
                <div class="grid grid-cols-3 gap-4">
                    <div class="overflow-y-auto rounded-md bg-white p-5 border border-gray-300 shadow-md">
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

                    <div id="section-animation" class="p-4 col-span-2 bg-white rounded-md border border-gray-300 shadow-md">

                        <div id="move-section" class="section hidden" role="region" aria-labelledby="section-move-title">
                            @component('components.move.move-file', [
                                'type' => $type ?? '',
                                'municipality' => $municiplaity ?? '',
                                'record' => $record ?? '',
                                'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                                'isArchived' => true,
                                'category' => $category ?? '',
                            ])
                            @endcomponent
                        </div>
                        <!--uploading files-->
                        <div id="upload-section" class="section hidden" role="region"
                            aria-labelledby="section-upload-title">
                            @component('components.file-upload.file-upload', [
                                'type' => $type ?? '',
                                'municipality' => $municiplaity ?? '',
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
                                'includePermit' => false,
                                'authId' => Auth::user()->id,
                            ])
                            @endcomponent
                        </div>
                        <div id="summary-section" class="section hidden" role="region"
                            aria-labelledby="section-summary-title">
                            @component('components.file-summary.file-summary', [
                                'type' => $type ?? '',
                                'municipality' => $municipality ?? '',
                                'record' => $record,
                            ])
                            @endcomponent
                        </div>
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
