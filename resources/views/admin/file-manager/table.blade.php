@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')
<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4">
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

        <div class="flex justify-end items-center">
            <div class="relative">
                <input type="text" id="customSearchInput"
                    class="placeholder:px-4 pl-2 py-1 rounded-md border border-gray-300" placeholder="Quick Search">
                <i class='bx bx-search absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
            </div>
        </div>

        <div class="my-4 space-x-3">
            <button class="bg-white px-2 p-1 rounded-md" id="uploadBtn">Upload File</button>
            <button class="bg-white px-2 p-1 rounded-md">Create a Folder</button>
            <button class="bg-white px-2 p-1 rounded-md">Sort By</button>
            <button class="bg-white px-2 p-1 rounded-md">View</button>
        </div>
        {{-- here point --}}
        <div class="relative">
            <div id="mainTable" class="transition-opacity duration-500 ease-in-out opacity-100">
                <div class="flex justify-between ">
                    <div class="flex items-center">
                        <label for="entriesSelect" class="mr-2 text-gray-700">Show</label>
                        <select id="entriesSelect" class="border border-gray-300 rounded-md px-2 py-1">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="ml-2 text-gray-700">entries</span>
                    </div>
                    <div id="customPagination" class="flex items-center space-x-2 py-1">
                        <button id="prevPage" class="px-4 py-1 bg-white rounded-md text-gray-700">Previous</button>
                        <span id="pageInfo" class="text-gray-700">Page 1 of 10</span>
                        <button id="nextPage" class="px-4 py-1 bg-white rounded-md text-gray-700">Next</button>
                    </div>
                </div>
                <div class="overflow-x-auto bg-white rounded-lg ">
                    <table id="default-table" class="min-w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300">Name</th>
                                <th class="border border-gray-300">Date Modified</th>
                                <th class="border border-gray-300">Modified By</th>
                                <th class="border border-gray-300">Category</th>
                                <th class="border border-gray-300">Classification</th>
                                <th class="border border-gray-300">Status</th>
                                <th class="border border-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="filesBody">
                            <!-- Data will be populated here -->
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
                                            "Date Modified",
                                            "Modified By",
                                            "Category",
                                            "Classification",
                                            "Status",
                                            "Actions" // Add the Actions column
                                        ],
                                        data: data.data.map((file) => [
                                            file.file_name,
                                            file.updated_at,
                                            file.user_name,
                                            file.category,
                                            file.classification,
                                            file.status,
                                            `
                            <button id="dropdownLeftButton${file.id}" data-dropdown-toggle="dropdownLeft${file.id}" data-dropdown-placement="left" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
                               <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdownLeft${file.id}"   class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow ">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLeftButton${file.id}">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">${file.id}</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Download</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Share</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">File Summary</a>
                                    </li>
                                </ul>
                            </div>
                        `
                                        ])
                                    };

                                    // Initialize the DataTable with options
                                    const options = {
                                        data: customData,
                                        paging: true,
                                        perPage: 5,
                                        searchable: true,
                                        sortable: true,
                                        scrollY: "300px",
                                    };

                                    const dataTable = new simpleDatatables.DataTable("#default-table", options);

                                    // After the table is rendered, initialize the dropdowns
                                    setTimeout(() => {
                                        data.data.forEach((file) => {
                                            const dropdownButton = document.getElementById(
                                                `dropdownLeftButton${file.id}`);
                                            const dropdownElement = document.getElementById(
                                                `dropdownLeft${file.id}`);

                                            // Ensure Flowbite's Dropdown object is initialized
                                            if (dropdownButton && dropdownElement) {
                                                new Dropdown(dropdownElement,
                                                    dropdownButton); // Initialize Flowbite Dropdown
                                            }
                                        });
                                    }, 100); // Add a delay to ensure elements are available in the DOM
                                })
                                .catch(error => {
                                    console.error('There was a problem with the fetch operation:', error);
                                });
                        });
                    </script>
                    <!-- Modal toggle -->
                </div>

            </div>



            <div id="uploadFileSection"
                class="absolute inset-0 transition-opacity duration-500 ease-in-out opacity-0 pointer-events-none">
                <div class="flex  gap-4">
                    <div class="overflow-x-auto w-5/12 gap-4 ">
                        <table id="minimizeTable"
                            class="min-w-full border border-gray-300 shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-white">
                                <tr class="text-sm leading-normal text-gray-600">
                                    <th class="py-3 px-6 border-b border-gray-300 text-left">Name</th>
                                    <th class="py-3 px-6 border-b border-gray-300 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm bg-white" id="filesBodyLimited">

                            </tbody>
                        </table>


                        <!-- Template for Action Dropdown -->

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const permitType = "{{ $type }}";
                                const municipality = "{{ $municipality }}";

                                // Fetch data from the API
                                fetch(`/api/files/${permitType}/${municipality}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const filesBodyLimited = document.getElementById('filesBodyLimited');

                                        // Populate the table with the fetched data
                                        data.data.forEach(file => {
                                            const row = document.createElement('tr');
                                            row.innerHTML = `
                                            <td class="py-3 px-6 border-b border-gray-300">${file.file_name}</td>
                                            <td class="py-3 px-6 border-b border-gray-300 relative">
                                                <button class="option-btn p-2 bg-gray-100 rounded hover:bg-gray-200"
                                                        onclick="showDropdown(event, ${row.id})">
                                                    <i class='bx bx-dots-vertical'></i>
                                                </button>
                                                <div id="dropdown-${row.id}" class="hidden absolute z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
                                                    <ul class="py-1 text-sm text-gray-700">
                                                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-100">Show</a></li>
                                                        <li><a href="#" class="block py-2 px-4 hover:bg-gray-100">Edit</a></li>
                                                    </ul>
                                                    <div class="py-1">
                                                        <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        `;
                                            filesBodyLimited.appendChild(row);
                                        });

                                        // Initialize DataTable after populating
                                        $('#minimizeTable').DataTable({
                                            dom: 't'
                                        });
                                    })
                                    .catch(error => console.error('Fetch error:', error));
                            });

                            // Show/Hide dropdown logic
                            function showDropdown(event, id) {
                                event.stopPropagation(); // Prevent click event from closing the dropdown immediately
                                const dropdown = document.getElementById(`dropdown-${id}`);

                                // Toggle the dropdown visibility
                                dropdown.classList.toggle('hidden');

                                // Close dropdown if clicking outside
                                document.addEventListener('click', function(e) {
                                    if (!dropdown.contains(e.target)) {
                                        dropdown.classList.add('hidden');
                                    }
                                }, {
                                    once: true
                                });
                            }
                        </script>


                    </div>

                    <div class="w-full p-4 bg-white rounded-md ">
                        <form id="upload-form" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="text-lg font-bold">Upload File</h2> {{-- add summary --}}
                                <button type="button" id="close-upload-section"
                                    class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                                    <i class='bx bx-x bx-md'></i>
                                </button>
                            </div>
                            <div class="" id="step-1">


                                <div class="flex items-center space-x-4">
                                    <label class="block mt-2">
                                        <input type="file" name="file" class="hidden" id="file-upload">
                                        <span
                                            class="inline-block bg-green-500 text-white rounded-md px-8 py-2 cursor-pointer hover:bg-green-600 transition duration-200">
                                            <i class='bx bx-cloud-upload'></i> Choose File
                                        </span>
                                    </label>

                                    <p id="file-upload-name"
                                        class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                                        No file chosen
                                    </p>


                                </div>

                                <p id="file-upload-error" class="text-red-500  min-h-[1.5rem] invisible mt-2 ml-32">
                                    Please choose a file to upload.</p>

                                <div class="flex my-2">
                                    <label for="office-source" class="text-black mt-2 mr-4 w-1/6">Office Source:</label>
                                    <div class="w-full">
                                        <input type="text" id="office-source" placeholder="Enter Value"
                                            class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                        <!-- Ensure the error message doesn't shift other elements -->
                                        <p id="office-source-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                            Please enter an Office Source.</p>
                                    </div>
                                </div>

                                <div class="flex  my-2">
                                    <label for="category" class="text-black mr-4 w-1/6">Category:</label>
                                    <div class="w-full">
                                        <select id="category" class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <option value="" disabled selected>Select a Category</option>
                                            <option value="incoming">Incoming</option>
                                            <option value="outgoing">Outgoing</option>

                                        </select>
                                    </div>

                                </div>

                                <div class="flex items-center my-4">
                                    <label for="classification" class="text-black mr-4 w-1/6">Classification:</label>
                                    <div class="w-full">
                                        <select id="classification"
                                            class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <option value="" disabled selected>Select a Classification</option>
                                            <option value="highly-technical">Highly Technical</option>
                                            <option value="simple">Simple</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex items-center my-4">
                                    <label for="status" class="text-black mr-4 w-1/6">Status:</label>
                                    <div class="w-full">
                                        <select id="status" class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <option value="" disabled selected>Select a Status</option>
                                            <option value="recieved">Recieved</option>
                                            <option value="outgoing">Outgoing</option>

                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" id="permit_type" value="{{ $type }}" name="permit-type">
                                @if (!isset($category))
                                    <input type="hidden" id="land_category" value="" name="land_category">
                                @else
                                    <input type="hidden" id="land_category" value="{{ $category }}"
                                        name="land_category">
                                @endif
                                <input type="hidden" id="municipality" value="{{ $municipality }}"
                                    name="municipality">




                                <div class="flex justify-end gap-4">

                                    <button type="button" id="next-step"
                                        class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                                        Next
                                    </button>

                                </div>
                            </div>

                            <div class="hidden" id="step-2">


                                <p id="file-upload-name2"
                                    class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                                    No file chosen
                                </p>

                                @if ($type == 'tree-cutting-permits')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class=" text-black mt-2 mr-4 w-1/6">Name
                                            of Client
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Value"
                                                class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter an Name Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="no-of-tree-species" class="text-black mt-2 mr-4 w-1/6">No. of Tree
                                            / Species</label>
                                        <div class="w-full">
                                            <input type="number" id="no-of-tree-species"
                                                placeholder="Enter number of trees / species"
                                                class="no-of-tree-species border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="no-of-tree-species-error"
                                                class="no-of-tree-species-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the number
                                                of trees and species.</p>
                                        </div>
                                    </div>



                                    <div class="flex mt-4">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Value"
                                                class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error"
                                                class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3 ">
                                            <p id="date-applied-error"
                                                class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'tree-plantation')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class=" text-black mt-2 mr-4 w-1/6">Name
                                            of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Value"
                                                class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="number_of_trees" class="text-black mt-2 mr-4 w-1/6">No. of Trees
                                            Planted</label>
                                        <div class="w-full">
                                            <input type="number" id="number_of_trees"
                                                placeholder="Enter number of trees"
                                                class="number_of_trees border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="number_of_trees-error"
                                                class="number_of_trees-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the number
                                                of trees.</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Value"
                                                class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error"
                                                class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error"
                                                class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'tree-transport-permits')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="number-of-trees" class="text-black mt-2 mr-4 w-1/6">Number of
                                            Trees</label>
                                        <div class="w-full">
                                            <input type="number" id="number-of-trees"
                                                placeholder="Enter Number of Trees"
                                                class="number-of-trees border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="number-of-trees-error"
                                                class="number-of-trees-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the number
                                                of trees</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="destination" class="text-black mt-2 mr-4 w-1/6">Destination</label>
                                        <div class="w-full">
                                            <input type="text" id="destination" placeholder="Enter Destination"
                                                class="destination border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="destination-error"
                                                class="destination-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Destionation</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error"
                                                class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-of-transport" class="text-black mt-2 mr-4 w-1/6">Date of
                                            Transport</label>
                                        <div class="w-full">
                                            <input type="date" id="date-of-transport"
                                                class="date-of-transport border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-of-transport-error"
                                                class="date-of-transport-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date of
                                                Transport</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'chainsaw-registration')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Location"
                                                class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error"
                                                class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="serial-number" class="text-black mt-2 mr-4 w-1/6">Serial
                                            Number</label>
                                        <div class="w-full">
                                            <input type="text" id="serial-number" placeholder="Enter Serial Number"
                                                class="serial-number border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="serial-number-error"
                                                class="serial-number-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Serial
                                                Number</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error"
                                                class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'land-titles')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Location"
                                                class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error"
                                                class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="lot-number" class="text-black mt-2 mr-4 w-1/6">Lot Number</label>
                                        <div class="w-full">
                                            <input type="text" id="lot-number" placeholder="Enter Lot Number"
                                                class="lot-number border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="lot-number-error"
                                                class="lot-number-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Lot Number</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="property-category" class="text-black mt-2 mr-4 w-1/6">Property
                                            Category</label>
                                        <div class="w-full">
                                            <select id="property-category"
                                                class="property-category border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                                <option value="" disabled selected>Select Property Category</option>
                                                <option value="residential">Residential</option>
                                                <option value="agricultural">Agricultural</option>
                                                <option value="special">Special</option>
                                            </select>
                                            <p id="property-category-error"
                                                class="property-category-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please select a Property
                                                Category</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4 flex justify-end gap-4">

                                    <button type="button" id="back"
                                        class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                                        Back
                                    </button>


                                    <button id="upload-btn" type="submit"
                                        class="bg-green-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition duration-200">
                                        <span id="button-spinner" class="hidden">
                                            <svg aria-hidden="true" role="status"
                                                class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="#E5E7EB" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentColor" />
                                            </svg>
                                            Loading...
                                        </span>
                                        <span id="button-text">Upload</span>
                                    </button>
                                </div>
                            </div>

                            <p id="error-message" class="mt-2 text-red-500 hidden"></p>
                            <p id="success-message" class="mt-2 text-green-500 hidden"></p>
                        </form>

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


                            const allowedTypes = ['application/pdf', 'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'image/jpeg', 'image/png', 'application/zip'
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



                        function populateTable(files) {
                            const tableBody = document.getElementById('filesBody'); // Assuming your table has a <tbody>
                            tableBody.innerHTML = ''; // Clear the existing rows
                            console.log(files);

                            files.forEach(file => {
                                const row = document.createElement('tr');
                                row.classList.add('border-b', 'border-black', 'hover:bg-gray-100');

                                row.innerHTML = `
                                    <td class="py-3 px-6 border-b border-gray-300">${file.file_name}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">${file.updated_at}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">${file.user_name}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">${file.category}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">${file.classification}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">${file.status}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">
                                        <div class="relative inline-block text-left">
                                            <button class="option-btn" data-id="${file.id}" onclick="toggleDropdown(event, 'main')">
                                                <i class='bx bx-dots-vertical'></i>
                                            </button>
                                            <div class="absolute right-0 hidden w-32 bg-white rounded-md shadow-lg" id="dropdown-main-${file.id}" style="z-index: 99;">
                                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="viewFile(${file.id})">View</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="downloadFile(${file.id})">Download</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="editFile(${file.id})">Edit</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="moveFile(${file.id})">Move</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="shareFile(${file.id})">Share</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="archiveFile(${file.id})">Archived</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="fileSumarry(${file.id})">File Summary</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                `;

                                tableBody.appendChild(row);
                            });
                        }

                        function populateTableLimited(files) {
                            const tableBody = document.getElementById('filesBodyLimited'); // Assuming your table has a <tbody>
                            tableBody.innerHTML = ''; // Clear the existing rows
                            console.log(files);

                            files.forEach(file => {
                                const row = document.createElement('tr');
                                row.classList.add('border-b', 'border-black', 'hover:bg-gray-100');

                                row.innerHTML = `
                                    <td class="py-3 px-6 border-b border-gray-300">${file.file_name}</td>
                                    <td class="py-3 px-6 border-b border-gray-300">
                                        <div class="relative inline-block text-left">
                                            <button class="option-btn" data-id="${file.id}" onclick="toggleDropdown(event, 'limited')">
                                                <i class='bx bx-dots-vertical'></i>
                                            </button>
                                            <div class="absolute  right-0 hidden w-32 bg-white rounded-md shadow-lg" id="dropdown-limited-${file.id}" style="z-index: 99;">
                                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="viewFile(${file.id})">View</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="downloadFile(${file.id})">Download</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="editFile(${file.id})">Edit</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="moveFile(${file.id})">Move</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="shareFile(${file.id})">Share</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="archiveFile(${file.id})">Archived</a>
                                                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="fileSumarry(${file.id})">File Summary</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                `;

                                tableBody.appendChild(row);
                            });
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

                            let fileId = 1;

                            fetch("{{ route('file.post') }}", {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {

                                    if (data.success) {
                                        showToast(data.message, true);
                                        fileId = data.fileId;

                                        let formPermit = new FormData();
                                        formPermit.append('file_id', fileId);
                                        formPermit.append('permit_type', permit_type);

                                        // Gather values based on form type
                                        if (permit_type === 'tree-cutting-permits') {
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

                                        console.log(permit_type)
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

                                        fetchFiles();

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
        document.getElementById('uploadBtn').addEventListener('click', function() {
            const mainTable = document.getElementById('mainTable');
            const uploadFileSection = document.getElementById('uploadFileSection');


            mainTable.classList.remove('opacity-100');
            mainTable.classList.add('opacity-0');


            setTimeout(() => {
                mainTable.classList.add('pointer-events-none');
                uploadFileSection.classList.remove('opacity-0', 'pointer-events-none');
                uploadFileSection.classList.add('opacity-100');
            }, 300);
        });

        document.getElementById('close-upload-section').addEventListener('click', function() {
            const mainTable = document.getElementById('mainTable');
            const uploadFileSection = document.getElementById('uploadFileSection');

            // Fade out the upload section
            uploadFileSection.classList.remove('opacity-100');
            uploadFileSection.classList.add('opacity-0');

            setTimeout(() => {
                // Disable pointer events on upload section
                uploadFileSection.classList.add('pointer-events-none');
                // Enable interactions on the main table
                mainTable.classList.remove('pointer-events-none'); // Enable interactions on main table
                // Make the main table visible
                mainTable.classList.remove('opacity-0'); // Ensure opacity is set back to fully visible
                mainTable.classList.add('opacity-100'); // Make main table fully visible
            }, 300); // Match this to your CSS transition duration
        });
    </script>

@endsection
