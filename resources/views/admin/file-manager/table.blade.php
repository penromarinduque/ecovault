@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@section('content')

    <div class="bg-slate-300 overflow-auto rounded-md text-black p-4">

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
                <button class="bg-white px-2 p-1 rounded-md" id="uploadBtn">Upload File</button>
                <button class="bg-white px-2 p-1 rounded-md">Create a Folder</button>

            </div>
        </div>

        <x-modal.file-modal />

        <div class="grid gap-60">
            <div id="mainTable" class="transition-opacity duration-500 ease-in-out opacity-100">
                <div class="overflow-x-auto bg-white rounded-lg p-5 ">

                    <table id="sorting-table">
                        <tbody>

                        </tbody>
                    </table>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const permitType = "{{ $type }}"; // Replace with your actual value
                            const municipality = "{{ $municipality }}"; // Replace with your actual value

                            fetch(`/api/files/${permitType}/${municipality}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                        const customData = {
                                            headings: [
                                                "Name",
                                                "Office Source",
                                                "Date Modified",
                                                "Modified By",
                                                "Category",
                                                "Classification",
                                                "Status",
                                                "Actions" // Add the Actions column
                                            ],
                                            data: data.data.map((file) => ({
                                                cells: [
                                                    file.file_name,
                                                    file.office_source,
                                                    file.updated_at,
                                                    file.user_name,
                                                    file.category,
                                                    file.classification,
                                                    file.status,
                                                    `<button id="dropdownLeftButton${file.id}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div id="dropdownLeft${file.id}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
                                    <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
                                        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" 
                                            onclick="openFileModal('/api/file/view/${file.id}', ${file.id})">
                                            View
                                        </a>
                                        <li><a href="#" class="block px-4 py-2  hover:bg-gray-100">Download</a></li>
                                        <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">Edit</button></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Share</a></li>
                                        <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">File Summary</button></li>  
                                        <li><button onclick="archiveFile(${file.id})" class="block px-4 py-2 hover:bg-gray-100">Archived</button></li>            
                                    </ul>
                                </div>`
                                                ],
                                                attributes: {
                                                    class: "text-gray-700 text-left hover:bg-gray-100"
                                                }
                                            })),
                                        };

                                        // Initialize the DataTable with options
                                        const dataTableElement = document.getElementById("sorting-table");
                                        if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
                                            const dataTable = new simpleDatatables.DataTable(dataTableElement, {
                                                    classes: {
                                                        dropdown: "datatable-perPage flex items-center", // Container for perPage dropdown
                                                        selector: "per-page-selector px-2 py-1 border rounded text-gray-600",
                                                        info: "datatable-info text-sm text-gray-500", // Class for the info text (pagination info)
                                                    },
                                                    labels: {
                                                        perPage: "<span class='text-gray-500 m-3'>Rows</span>", // Custom text for perPage dropdown
                                                        searchTitle: "Search through table data", // Title attribute for the search input
                                                    },
                                                    template: (options, dom) =>
                                                        @verbatim `<div class='${options.classes.top}'>
${options.paging && options.perPageSelect ?
`<div class='${options.classes.dropdown}'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <select class='${options.classes.selector}'></select> ${options.labels.perPage}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>` : ""}
${options.searchable ?
`<div class='${options.classes.search}'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input class='${options.classes.input}' placeholder='${options.labels.placeholder}' type='search' title='${options.labels.searchTitle}'${dom.id ? ` aria-controls="${dom.id}"` : ""}>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>` : ""}
</div>
<div class='${options.classes.container}'${options.scrollY.length ? ` style='height: ${options.scrollY}; overflow-Y: auto;'` : ""}></div>
<div class='${options.classes.bottom}'>
${options.paging ? `<div class='${options.classes.info}'></div>` : ""}
<nav class='${options.classes.pagination}'></nav>
</div>`
                                                @endverbatim ,
                                                searchable: true,
                                                perPageSelect: true,
                                                sortable: true,
                                                perPage: 5, // set the number of rows per page
                                                perPageSelect: [5, 10, 20, 50],
                                                data: customData
                                            });

                                        function initializeDropdowns() {
                                            data.data.forEach((file) => {
                                                const dropdownButton = document.getElementById(
                                                    `dropdownLeftButton${file.id}`);
                                                const dropdownElement = document.getElementById(`dropdownLeft${file.id}`);
                                                if (dropdownButton && dropdownElement) {
                                                    const options = {
                                                        placement: 'left',
                                                        triggerType: 'click',
                                                        offsetSkidding: 0,
                                                        offsetDistance: 0,
                                                        ignoreClickOutsideClass: false,
                                                    };
                                                    new Dropdown(dropdownElement, dropdownButton, options);
                                                }
                                            });
                                        }


                                        // Listen to events that indicate table content updates
                                        dataTable.on("datatable.page", initializeDropdowns);
                                        dataTable.on("datatable.update", initializeDropdowns);

                                        // Initial call for dropdowns in the first page
                                        initializeDropdowns(data);
                                    }
                                })



                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                        });

                        async function archiveFile(fileId) {
                            const csrfToken = document.querySelector('input[name="_token"]').value;

                            try {
                                const response = await fetch(`/api/file/archived/${fileId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken // CSRF token for security
                                    },
                                });

                                const result = await response.json();

                                if (response.ok && result.success) {
                                    //alert('File archived successfully!');
                                    // Optionally, update the UI to show the file as archived
                                } else {
                                    alert('Failed to archive the file.');
                                    console.error(result.message || 'Unknown error');
                                }
                            } catch (error) {
                                console.error('Error archiving the file:', error);
                                alert('An error occurred while archiving the file.');
                            }
                        }
                    </script>



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
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const permitType = "{{ $type }}"; // Replace with your actual value
                                const municipality = "{{ $municipality }}"; // Replace with your actual value

                                fetch(`/api/files/${permitType}/${municipality}`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        const customData = {
                                            headings: [
                                                "Name",
                                                "Actions"
                                            ],
                                            data: data.data.map((file) => ({
                                                cells: [
                                                    file.file_name,
                                                    `<button id="miniBtn${file.id}" data-dropdown-toggle="miniDropdown${file.id}" data-dropdown-placement="left" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        </svg>
                                                    </button>
                                                    <div id="miniDropdown${file.id}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                                                        <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400" aria-labelledby="miniBtn${file.id}">
                                                            <li><a href="/api/files/${file.id}" class="block px-4 py-2 hover:bg-gray-100">View</a></li>
                                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
                                                            <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">Edit</button></li>
                                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
                                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Share</a></li>
                                                            <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">File Summary</button></li> 
                                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Archived</a></li>
                                                        </ul>
                                                    </div>`
                                                ],
                                                attributes: {
                                                    class: "text-black text-left hover:bg-gray-100"
                                                }
                                            })),
                                        };

                                        // Initialize the DataTable with options
                                        const dataTableElement = document.getElementById("minimizeTable");
                                        if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
                                            const dataTable = new simpleDatatables.DataTable(dataTableElement, {
                                                searchable: false,
                                                sortable: false,
                                                paging: true, // Enable pagination
                                                perPage: 5, // Show 5 entries per page
                                                perPageSelect: false, // Disable per-page selection dropdown
                                                info: false, // Enable showing "Showing X to Y of Z entries"
                                                data: customData, // Pass the full data
                                                labels: {
                                                    perPage: "<span class='text-gray-500 m-3'>Rows</span>", // Custom text for perPage dropdown
                                                    searchTitle: "Search through table data", // Title attribute for the search input
                                                    loading: "Loading...",
                                                    info: "Showing {end} of {rows} rows" // Pagination info text
                                                },
                                            });

                                            // Initialize dropdowns for the current rows
                                            function initializeDropdowns() {
                                                data.data.forEach((file) => {
                                                    const dropdownButton = document.getElementById(`miniBtn${file.id}`);
                                                    const dropdownElement = document.getElementById(
                                                        `miniDropdown${file.id}`);

                                                    if (dropdownButton && dropdownElement) {
                                                        new Dropdown(dropdownElement, dropdownButton);
                                                    }
                                                });
                                            }

                                            // Listen to events that indicate table content updates
                                            dataTable.on("datatable.page", initializeDropdowns);
                                            dataTable.on("datatable.update", initializeDropdowns);
                                            initializeDropdowns(); // Initial call for dropdowns in the first page
                                        }
                                    })
                                    .catch(error => {
                                        console.error('There was a problem with the fetch operation:', error);
                                    });
                            });
                        </script>
                    </div>

                    <div class=" p-4 col-span-2 bg-white rounded-md ">
                        {{-- this for upload --}}
                        @include('admin.file-manager.component.upload-file')
                        {{-- this for file edit --}}
                        @include('admin.file-manager.component.edit-file')
                        @include('admin.file-manager.component.file-summary')

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

                    <script>
                        const fileInput = document.getElementById('file-upload');
                        const fileUploadName = document.getElementById('file-upload-name');
                        const fileUploadNameStep2 = document.getElementById('file-upload-name2');
                        const fileUploadError = document.getElementById('file-upload-error');


                        function validateFile() {
                            const file = fileInput.files[0];


                            if (fileInput.files.length === 0) {
                                fileUploadError.textContent = "Please upload a file.";
                                fileUploadError.classList.remove('invisible');
                                return false; // Validation failed
                            }


                            const allowedTypes = [
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'image/jpeg',
                                'image/png',
                                'application/zip',
                                'application/x-zip-compressed', // Some browsers may use this
                                'multipart/x-zip' // Occasionally used
                            ];


                            if (!allowedTypes.includes(file.type)) {
                                fileUploadError.textContent = "Invalid file type. Please upload a PDF, Word document, image, or ZIP file.";
                                fileUploadError.classList.remove('invisible');
                                return false;
                            }

                            const maxSize = 5 * 1024 * 1024;
                            if (file.size > maxSize) {
                                fileUploadError.textContent = "File size exceeds 2 MB. Please upload a smaller file.";
                                fileUploadError.classList.remove('invisible');
                                return false;
                            }


                            fileUploadError.classList.add('invisible');
                            return true;

                        }

                        document.getElementById('next-step').addEventListener('click', function() {
                            let isValid = true;

                            if (!validateFile()) {
                                return
                            }

                            const officeSourceInput = document.getElementById('office-source');
                            const officeSourceError = document.getElementById('office-source-error');


                            const categorySelect = document.getElementById('category');
                            const classificationSelect = document.getElementById('classification');
                            const statusSelect = document.getElementById('status');



                            officeSourceInput.classList.remove('border-red-500');
                            officeSourceError.classList.add('invisible');
                            categorySelect.classList.remove('border-red-500');
                            classificationSelect.classList.remove('border-red-500');
                            statusSelect.classList.remove('border-red-500');

                            if (officeSourceInput.value.trim() === '') {
                                officeSourceInput.classList.add('border-red-500');
                                officeSourceError.classList.remove('invisible'); // Show error message
                                isValid = false;
                            }

                            // Validate 'Category' select
                            if (categorySelect.value === '') {
                                categorySelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Validate 'Classification' select
                            if (classificationSelect.value === '') {
                                classificationSelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Validate 'Status' select
                            if (statusSelect.value === '') {
                                statusSelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Only move to step 2 if all fields are valid
                            if (isValid) {
                                document.getElementById('step-1').classList.add('hidden');
                                document.getElementById('step-2').classList.remove('hidden');

                                const selectedFile = fileInput.files[0]; // Get the selected file
                                fileUploadNameStep2.textContent = `File: ${selectedFile.name}`;
                            }
                        });

                        document.getElementById('office-source').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                            document.getElementById('office-source-error').classList.add('invisible');

                        })


                        document.getElementById('category').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                            this.classList.add('text-black')

                        });

                        document.getElementById('classification').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                        });

                        document.getElementById('status').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                        });

                        document.getElementById('back').addEventListener('click', function() {

                            document.getElementById('step-1').classList.remove('hidden');
                            document.getElementById('step-2')
                                .classList.add('hidden');
                        })


                        fileInput.addEventListener('change', function() {
                            const fileUploadError = document.getElementById('file-upload-error');

                            if (fileInput.files.length > 0) {
                                const selectedFile = fileInput.files[0];
                                fileUploadName.textContent = selectedFile.name; // Update Step 1
                                fileUploadError.classList.add('invisible'); // Hide error if file is chosen
                            } else {
                                fileUploadName.textContent = 'No file chosen'; // Reset if no file is chosen
                                fileUploadError.classList.remove('invisible'); // Show error if no file is chosen
                            }
                        });

                        function showToast(message, isSuccess) {
                            const toast = document.getElementById('toast');
                            const toastMessage = document.getElementById('toast-message');
                            const toastClose = document.getElementById('toast-close');
                            const toastTimer = document.getElementById('toast-timer');

                            toastMessage.textContent = message;
                            toast.classList.remove('hidden');


                            if (isSuccess) {
                                toast.classList.add('bg-green-500');
                                toast.classList.remove('bg-red-500');
                                toastTimer.classList.remove('bg-red-300');
                                toastTimer.classList.add('bg-green-300');
                            } else {
                                toast.classList.add('bg-red-500');
                                toast.classList.remove('bg-green-500');
                                toastTimer.classList.remove('bg-green-300');
                                toastTimer.classList.add('bg-red-300');
                            }

                            let timerDuration = 3000;
                            let timerWidth = 100;


                            toastTimer.style.width = '100%';


                            const timerInterval = setInterval(() => {
                                timerWidth -= (100 / (timerDuration / 100));
                                toastTimer.style.width = `${timerWidth}%`;
                            }, 100);


                            setTimeout(() => {
                                clearInterval(timerInterval);
                                toast.classList.add('hidden');
                            }, timerDuration);


                            toastClose.onclick = function() {
                                clearInterval(timerInterval);
                                toast.classList.add('hidden');
                            };
                        }

                        function toggleDropdown(event, type) {
                            event.stopPropagation(); // Prevent event bubbling
                            const button = event.currentTarget; // The button that was clicked
                            const dropdownId = type === 'main' ? `dropdown-main-${button.getAttribute('data-id')}` :
                                `dropdown-limited-${button.getAttribute('data-id')}`; // Determine which dropdown to toggle
                            const dropdown = document.getElementById(dropdownId); // Get the dropdown element

                            // Close any open dropdowns before opening a new one
                            const existingDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                            existingDropdowns.forEach(d => {
                                if (d !== dropdown) {
                                    d.classList.add('hidden'); // Hide other dropdowns
                                }
                            });

                            // Calculate the position for fixed positioning
                            const rect = button.getBoundingClientRect(); // Get the button's position
                            const dropdownHeight = dropdown.offsetHeight; // Get the dropdown's height
                            const viewportHeight = window.innerHeight; // Get the height of the viewport

                            // Check available space below the button
                            if (rect.bottom + dropdownHeight > viewportHeight) {
                                // Not enough space below, position it above
                                dropdown.style.top = `${rect.top - dropdownHeight - 200}px`; // Place above the button
                            } else {
                                // Enough space below, place it below the button
                                dropdown.style.top = `${rect.bottom + 5}px`; // Place below the button
                            }
                            dropdown.style.position = 'fixed'; // Use fixed positioning
                            dropdown.style.left = `${rect.left}px`; // Align with the button

                            // Toggle the dropdown visibility
                            dropdown.classList.toggle('hidden');
                        }

                        // Close dropdowns when clicking outside
                        document.addEventListener('click', function() {
                            const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
                            dropdowns.forEach(dropdown => dropdown.classList.add('hidden')); // Hide all dropdowns
                        });




                        // Define your action functions
                        function viewFile(id) {
                            console.log(`View file with ID: ${id}`);
                            // Implement the view logic (e.g., open a modal or redirect)
                        }

                        function moveFile(id) {
                            console.log(`Move file with ID: ${id}`);
                            // Implement the move logic (e.g., open a modal or redirect)
                        }

                        function deleteFile(id) {
                            if (confirm('Are you sure you want to delete this file?')) {
                                console.log(`Delete file with ID: ${id}`);
                                // Implement the delete logic (e.g., make an AJAX call to delete the file)
                            }
                        }

                        document.getElementById('upload-form').addEventListener('submit', function(e) {
                            e.preventDefault();

                            let isValid = true; // Use 'let' so it can be reassigned

                            let nameOfClient = document.querySelector('.name-of-client');
                            let nameOfClientError = document.querySelector('.name-of-client-error')
                            if (nameOfClient && nameOfClient.value === "") {
                                nameOfClient.classList.add("border-red-500");
                                nameOfClientError.classList.remove("invisible")
                                isValid = false; // Reassigning isValid to false if validation fails
                            }

                            let noOfTreeSpecies = document.querySelector('.no-of-tree-species')
                            let noOfTreeSpeciesError = document.querySelector('.no-of-tree-species-error')
                            if (noOfTreeSpecies && noOfTreeSpecies.value === "") {
                                noOfTreeSpecies.classList.add("border-red-500");
                                noOfTreeSpeciesError.classList.remove("invisible")
                                isValid = false;
                            }

                            let location = document.querySelector('.location');
                            let locationError = document.querySelector('.location-error');
                            if (location && location.value === "") {
                                location.classList.add("border-red-500");
                                locationError.classList.remove("invisible");
                                isValid = false;
                            }

                            let dateApplied = document.querySelector('.date-applied');
                            let dateAppliedError = document.querySelector('.date-applied-error');
                            if (dateApplied && dateApplied.value === "") {
                                dateApplied.classList.add("border-red-500");
                                dateAppliedError.classList.remove("invisible");
                                isValid = false;
                            }

                            let numberOfTrees = document.querySelector('.number_of_trees, .number-of-trees');
                            let numberOfTreesError = document.querySelector('.number_of_trees-error, .number-of-trees-error');
                            if (numberOfTrees && numberOfTrees.value === "") {
                                numberOfTrees.classList.add("border-red-500");
                                numberOfTreesError.classList.remove("invisible");
                                isValid = false;
                            }

                            let destination = document.querySelector('.destination');
                            let destinationError = document.querySelector('.destination-error');
                            if (destination && destination.value === "") {
                                destination.classList.add("border-red-500");
                                destinationError.classList.remove("invisible");
                                isValid = false;
                            }

                            let dateOfTransport = document.querySelector('.date-of-transport');
                            let dateOfTransportError = document.querySelector('.date-of-transport-error');
                            if (dateOfTransport && dateOfTransport.value === "") {
                                dateOfTransport.classList.add("border-red-500");
                                dateOfTransportError.classList.remove("invisible");
                                isValid = false;
                            }

                            let serialNumber = document.querySelector('.serial-number');
                            let serialNumberError = document.querySelector('.serial-number-error');
                            if (serialNumber && serialNumber.value === "") {
                                serialNumber.classList.add("border-red-500");
                                serialNumberError.classList.remove("invisible");
                                isValid = false;
                            }

                            let lotNumber = document.querySelector('.lot-number');
                            let lotNumberError = document.querySelector('.lot-number-error');
                            if (lotNumber && lotNumber.value === "") {

                                lotNumber.classList.add("border-red-500");
                                lotNumberError.classList.remove("invisible");
                                isValid = false;
                            }

                            let propertyCategory = document.querySelector('.property-category');

                            if (propertyCategory && propertyCategory.value === "") {
                                propertyCategory.classList.add("border-red-500");
                                isValid = false;
                            }

                            if (!isValid) {
                                return; // Stop further execution if validation fails
                            }


                            const submitButton = document.getElementById('upload-btn');
                            const buttonText = document.getElementById('button-text');
                            const buttonSpinner = document.getElementById('button-spinner');

                            submitButton.disabled = true;
                            buttonText.classList.add('hidden'); // Hide the button text
                            buttonSpinner.classList.remove('hidden');

                            const formData = new FormData(this);
                            const csrfToken = document.querySelector('input[name="_token"]').value;

                            const officeSource = document.getElementById('office-source').value;
                            const category = document.getElementById('category').value;
                            const classification = document.getElementById('classification').value;
                            const status = document.getElementById('status').value;
                            const permit_type = document.getElementById("permit_type").value;
                            const land_category = document.getElementById("land_category").value;
                            const municipality = document.getElementById("municipality").value;


                            formData.append('office_source', officeSource);
                            formData.append('category', category);
                            formData.append('classification', classification);
                            formData.append('status', status);
                            formData.append('permit_type', permit_type);
                            formData.append('land_category', land_category);
                            formData.append('municipality', municipality);

                            let fileId;

                            fetch("{{ route('file.post') }}", {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log(document.getElementById('name-of-client')
                                        .value);
                                    if (data.success) {
                                        showToast(data.message, true);
                                        fileId = data.fileId;

                                        let formPermit = new FormData();
                                        formPermit.append('file_id', fileId);
                                        formPermit.append('permit_type', permit_type);

                                        // Gather values based on form type
                                        if (permit_type === 'tree-cutting-permits') {
                                            formPermit.append('species', document.getElementById('species').value);
                                            formPermit.append('name_of_client', document.getElementById('name-of-client')
                                                .value);
                                            formPermit.append('number_of_trees', document.getElementById(
                                                    'no-of-tree-species')
                                                .value);
                                            formPermit.append('location', document.getElementById('location').value);
                                            formPermit.append('date_applied', document.getElementById('date-applied')
                                                .value);
                                        } else if (permit_type === 'tree-plantation') {
                                            formPermit.append('name_of_client', document.getElementById('name-of-client')
                                                .value);
                                            formPermit.append('number_of_trees', document.getElementById(
                                                'number_of_trees').value);
                                            formPermit.append('location', document.getElementById('location').value);
                                            formPermit.append('date_applied', document.getElementById('date-applied')
                                                .value);
                                        } else if (permit_type === 'tree-transport-permits') {
                                            formPermit.append('species', document.getElementById('species').value);
                                            formPermit.append('name_of_client', document.getElementById('name-of-client')
                                                .value);
                                            formPermit.append('number_of_trees', document.getElementById('number-of-trees')
                                                .value);
                                            formPermit.append('destination', document.getElementById('destination')
                                                .value);
                                            formPermit.append('date_applied', document.getElementById('date-applied')
                                                .value);
                                            formPermit.append('date_of_transport', document.getElementById(
                                                    'date-of-transport')
                                                .value);
                                        } else if (permit_type === 'chainsaw-registration') {
                                            formPermit.append('name_of_client', document.getElementById('name-of-client')
                                                .value);
                                            formPermit.append('location', document.getElementById('location').value);
                                            formPermit.append('serial_number', document.getElementById('serial-number')
                                                .value);
                                            formPermit.append('date_applied', document.getElementById('date-applied')
                                                .value);
                                        } else if (permit_type === 'land-titles') {
                                            formPermit.append('name_of_client', document.getElementById('name-of-client')
                                                .value);
                                            formPermit.append('location', document.getElementById('location').value);
                                            formPermit.append('lot_number', document.getElementById('lot-number').value);
                                            formPermit.append('property_category', document.getElementById(
                                                    'property-category')
                                                .value);
                                        }

                                        console.log(permit_type);
                                        fetch("{{ route('permit.post') }}", {
                                                method: 'POST',
                                                body: formPermit,
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken
                                                }

                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    console.log("Scueeess")
                                                }
                                            })
                                            .catch((error) => {

                                                showToast(error || 'File upload failed.', false);
                                            });

                                        // fetchFiles();

                                    } else {
                                        console.log(data);
                                        showToast(data.message || 'File upload failed.', false);
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                }).finally(() => {

                                    this.reset();

                                    const fileInput = document.getElementById('file-upload');
                                    const fileUploadName = document.getElementById('file-upload-name');
                                    const fileUploadNameStep2 = document.getElementById('file-upload-name2');

                                    fileUploadName.textContent = 'No file chosen';
                                    fileUploadNameStep2.textContent = 'No file chosen';

                                    submitButton.disabled = false;
                                    buttonText.classList.remove('hidden'); // Show the button text again
                                    buttonSpinner.classList.add('hidden'); // Hide the spinner
                                    document.getElementById('step-1').classList.remove('hidden');
                                    document.getElementById('step-2')
                                        .classList.add('hidden');
                                });
                        });
                    </script>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Function to handle fading out and in sections
        function toggleSections(showFileSection) {
            const mainTable = document.getElementById('mainTable');
            const fileSection = document.getElementById('fileSection');

            if (showFileSection) {
                // Fade out the main table
                mainTable.classList.remove('opacity-100');
                mainTable.classList.add('opacity-0');

                setTimeout(() => {
                    mainTable.classList.add('pointer-events-none', 'hidden'); // Add hidden after fade-out is done
                    // Fade in the file section
                    fileSection.classList.remove('opacity-0', 'hidden', 'pointer-events-none');
                    fileSection.classList.add('opacity-100');
                }, 300); // Match this to your CSS transition duration
            } else {
                // Fade out the file section
                fileSection.classList.remove('opacity-100');
                fileSection.classList.add('opacity-0');

                setTimeout(() => {
                    fileSection.classList.add('pointer-events-none', 'hidden'); // Add hidden after fade-out is done
                    mainTable.classList.remove('pointer-events-none', 'hidden', 'opacity-0');
                    mainTable.classList.add('opacity-100');
                }, 300); // Match this to your CSS transition duration
            }
        }

        // Helper function to show the correct div and hide others
        function toggleDivVisibility(showDivId) {
            const sections = ['upload-file-div', 'edit-file-div', 'file-summary-div'];
            sections.forEach(section => {
                const sectionDiv = document.getElementById(section);
                if (section === showDivId) {
                    sectionDiv.classList.remove('hidden');
                } else {
                    sectionDiv.classList.add('hidden');
                }
            });
        }

        // Event listener for the upload button
        document.getElementById('uploadBtn').addEventListener('click', function() {
            toggleSections(true);
            toggleDivVisibility('upload-file-div');
        });

        // Event listener for the edit button
        document.body.addEventListener('click', function(event) {
            if (event.target.matches('.edit-button')) {
                toggleSections(true);
                const fileId = event.target.dataset.fileId; // Get the file ID if needed
                console.log('Edit button clicked for file ID:', fileId);
                fetchFileData(fileId);
                toggleDivVisibility('edit-file-div');
            }
        });

        // Event listener for the file summary button
        document.body.addEventListener('click', function(event) {
            if (event.target.matches('.file-summary-button')) {
                toggleSections(true);
                const fileId = event.target.dataset.fileId; // Get the file ID from the button
                console.log('File Summary button clicked for file ID:', fileId);
                fetchFileDetails(fileId); // Call a function to fetch file summary data
                toggleDivVisibility('file-summary-div');
            }
        });

        // Event listener for the close buttons in the file section
        document.getElementById('close-upload-btn').addEventListener('click', function() {
            toggleSections(false);
        });

        document.getElementById('close-edit-btn').addEventListener('click', function() {
            toggleSections(false);
        });

        document.getElementById('close-summary-btn').addEventListener('click', function() {
            toggleSections(false);
        });
    </script>


    <script src="{{ asset('js/file-modal.js') }}"></script>
@endsection
