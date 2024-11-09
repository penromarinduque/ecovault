@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')


    <div class="bg-slate-200  rounded-md text-black p-4 ">
        <div>
            <nav aria-label="Breadcrumb">
                <ol class="flex space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('file-manager.show') }}"><span class="">Administrative Reports</span></a>
                    </li>
                    <li><span class="text-gray-400"> &gt; </span></li>
                    <li><a class="font-bold">{{ $record }}</a></li>
                </ol>
            </nav>

            <div class="my-4 space-x-3">
                <x-button id="uploadBtn" label="Upload File" type="submit" style="primary" />
                <x-button id="" label="Create a Folder" style="secondary" />

            </div>

            <x-modal.file-modal />
            <x-file-share.file-share :includePermit="false" />

            <div class="grid">
                <div id="mainTable" class="transition-opacity duration-500 ease-in-out opacity-100">
                    <div class="overflow-x-auto bg-white rounded-lg p-5">
                        @component('components.forms.table', [
                            'record' => $record,
                            'type' => '',
                            'municipality' => '',
                            'isAdmin' => auth()->check() && auth()->user()->isAdmin,
                            'isArchived' => false,
                        ])
                            <!--add something to use in the table updated by harvs-->
                        @endcomponent
                    </div>
                </div>
                @include('admin.administrative.component.file-request')
                <div id="fileSection" class="transition-opacity duration-500 ease-in-out opacity-0 hidden">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="overflow-auto  rounded-lg bg-white p-5">
                            <table id="minimizeTable" class="">
                                <tbody>
                                    <!-- Minimize table content goes here -->
                                </tbody>
                            </table>
                        </div>

                        <div class=" p-4 col-span-2 bg-white rounded-md ">

                            {{-- this for upload --}}
                            @include('admin.administrative.component.upload-file', [
                                'record' => $record,
                            ])
                            {{-- this for file edit --}}
                            @include('admin.administrative.component.edit-file')
                            @include('admin.administrative.component.file-summary')

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
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("file-request-form").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the file ID and user ID
                const fileId = document.getElementById("request-file-id").value; // Get file ID
                const userId = document.getElementById("request-user-id")
                    .value; // Get user ID from hidden input

                // Get other form values
                const requestedPermission = document.getElementById("category")
                    .value; // Get selected permission
                const remarks = document.getElementById("remarks").value; // Get remarks
                const csrfToken = document.querySelector('input[name="_token"]').value;

                // Create the request payload
                const requestData = {
                    file_id: fileId,
                    requested_by_user_id: userId, // Current user's ID
                    requested_permission: requestedPermission,
                    remarks: remarks
                };

                // Make the POST request using Fetch API
                fetch(`/api/files/request/${fileId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(requestData), // Convert requestData to JSON
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json(); // Parse the JSON response
                    })
                    .then(data => {
                        // Hide the modal after a successful request
                        document.getElementById("file-request").classList.add("hidden");
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        function requestAccess(fileId, fileName) {

            const fileNameInput = document.getElementById("file-request_name");

            if (fileSectionFileRequest && fileNameInput) {
                fileSectionFileRequest.classList.remove("hidden");
                fileNameInput.value = fileName;
                document.getElementById("request-file-id").value = fileId;

            } else {
                console.error("Modal or File Name Input not found");
            }
        }
        const fileSectionFileRequest = document.getElementById("file-request");

        function requestAccess(fileId, fileName) {

            const fileNameInput = document.getElementById("file-request_name");

            if (fileSectionFileRequest && fileNameInput) {
                fileSectionFileRequest.classList.remove("hidden");
                fileNameInput.value = fileName;
                document.getElementById("request-file-id").value = fileId;

            } else {
                console.error("Modal or File Name Input not found");
            }
        }

        const exitButtonFileRequest = document.getElementById("close-file-request-btn");

        exitButtonFileRequest.addEventListener("click", (event) => {
            event.preventDefault();
            fileSectionFileRequest.classList.add("hidden");
        })
    </script>

    {{-- <script src="{{ asset('js/administrative.js') }}"></script> --}}
    <script src="{{ asset('js/file-share.js') }}"></script>
    <script src="{{ asset('js/file-modal.js') }}"></script>
@endsection
