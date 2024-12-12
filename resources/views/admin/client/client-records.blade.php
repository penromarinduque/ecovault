@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="grid grid-cols-4 gap-6">
        <section class="col-span-1">
            <div class="space-y-6 bg-white p-6 border border-gray-200 rounded-lg shadow">
                <!-- Combined Form -->
                <form id="filter-form" class="max-w-md mx-auto space-y-6 font-medium">
                    @csrf
                    <label for="client-search" class="mb-2 text-sm font-medium  sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="client-search" name="client-search"
                            class=" bg-gray-50 border border-gray-300 text-green-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-3 ps-10 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            placeholder="Search name of client" required autocomplete="off" />

                    </div>

                    <select id="select-permit-type" name="permit_type" required
                        class=" bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-3 capitalize
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100">
                        <option value="" disabled selected>Select permit type</option>
                        <!-- Add your options here -->
                    </select>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center ps-4 border border-gray-500 rounded">
                            <input type="checkbox" id="archived-checkbox" name="archived" value=""
                                class=" text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="archived-checkbox"
                                class="w-full ms-2 text-sm font-medium text-gray-900">Archived</label>
                        </div>

                        <div>
                            <select id="classification" name="classification"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                required>
                                <option value="" disabled selected hidden>Classification</option>
                                <option value="highly-technical">Highly Technical</option>
                                <option value="simple">Simple</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-sm text-sm px-4 py-2">Search</button>
                </form>


                <!-- Display filtered data here -->
                <div id="files-list"></div>

            </div>

        </section>

        <!--second section-->
        <section class="col-span-3">

            <div class="w-full">
                {{-- <form class="grid grid-cols-2">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search..." required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                    </div>
                </form> --}}
            </div>

            @component('components.client-filter.client-filter', [
                //Enter here for passing variable(future purposes)
            ])
            @endcomponent

        </section>
    </div>
    <template id="tree-cutting-template">

    </template>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            permitType();
            const filterForm = document.getElementById('filter-form');

            filterForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                const formData = new FormData(filterForm);
                const clientSearch = formData.get('client-search');
                const permitType = formData.get('permit_type');
                const archivedCheckbox = document.getElementById('archived-checkbox');
                const archived = archivedCheckbox.checked; // True if checked, false if unchecked
                const classification = formData.get('classification');

                try {
                    // Pass form data as query parameters
                    const response = await fetch(`/files/filter?` + new URLSearchParams({
                        'client-search': clientSearch,
                        'permit_type': permitType,
                        'archived': archived,
                        'classification': classification,
                    }));
                    console.log(classification)
                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }

                    const data = await response.json();


                    // Handle response data
                    data.data.forEach(file => {
                        switch (file.permit_type) {
                            case 'tree-cutting-permits':
                                const template = document.getElementById(
                                    'tree-cutting-template');
                                const clone = document.importNode(template.content, true);

                                // Fill the template with values from the file object
                                Object.entries(file).forEach(([key, value]) => {
                                    const element = clone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent = value;
                                    }
                                });

                                // Assign a unique class or data attribute to the tbody using file.id
                                const tableBody = clone.querySelector('tbody');
                                tableBody.setAttribute('data-file-id', file
                                    .id); // Use data attribute for unique identification

                                // Append the cloned template to the container
                                document.getElementById('template-container').appendChild(
                                    clone);

                                // Loop through the details and add rows to the table for this specific file
                                file.details.forEach(detail => {
                                    let row = `<tr class="odd:bg-white even:bg-gray-100">
                    <td class="px-6 py-3">${detail.species || ''}</td>
                    <td class="px-6 py-3">${detail.number_of_trees || ''}</td>
                    <td class="px-6 py-3">${detail.location || ''}</td>
                    <td class="px-6 py-3">${detail.date_applied || ''}</td>
                </tr>`;
                                    // Insert the row into the correct table based on the file id
                                    const tableBody = document.querySelector(
                                        `[data-file-id="${file.id}"]`);
                                    if (tableBody) {
                                        tableBody.insertAdjacentHTML('beforeend', row);
                                    }
                                });
                                break;

                            case 'chainsaw-registration':
                                // Handle chainsaw-registration logic here
                                console.log('Chainsaw Registration:', file);
                                break;

                            case 'tree-plantation-registration':
                                // Handle tree-plantation-registration logic here
                                console.log('Tree Plantation Registration:', file);
                                break;

                            case 'transport-permit':
                                // Handle transport-permit logic here
                                console.log('Transport Permit:', file);
                                break;

                            case 'land-title':
                                // Handle land-title logic here
                                console.log('Land Title:', file);
                                break;

                            default:
                                // Handle any other or unknown permit type
                                console.log('Unknown Permit Type:', file);
                        }
                    });

                } catch (error) {
                    console.error('Error fetching files:', error);
                }
            });


        });

        async function permitType() {
            const select = document.getElementById('select-permit-type');

            try {
                const response = await fetch('/api/permit/type'); // Adjust URL if necessary

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && Array.isArray(data.permitTypes)) {
                    // Clear existing options
                    select.innerHTML = `
                <option value="" disabled selected hidden>Select Permit Type</option>
            `;

                    // Populate the dropdown
                    data.permitTypes.forEach((type) => {
                        const option = document.createElement('option');
                        option.value = type.type_name;
                        option.textContent = type.type_name.replace(/-/g, ' ');
                        select.appendChild(option);
                    });
                } else {
                    console.error('Invalid response:', data);
                    select.innerHTML = `
                <option value="" disabled>No permit types available</option>
            `;
                }
            } catch (error) {
                console.error('Error fetching permit types:', error.message);

                // Show error in dropdown
                select.innerHTML = `
            <option value="" disabled>Error loading permit types</option>
        `;
            }
        }
    </script>

    {{-- <script>
        //love what you are doing

        let dataTable;
        let type = {!! json_encode($type ?? 'tree-cutting-permits') !!};
        let municipality = {!! json_encode($municipality ?? 'Boac') !!};
        let category = {!! json_encode($category ?? '') !!};

        document.addEventListener("DOMContentLoaded", function() {
            // Define parameters for the request
            fetchClientFiles();
        });

        async function fetchClientFiles() {

            const params = {
                type: type,
                municipality: municipality,
                category: category,
            };

            // Remove empty parameters
            const filteredParams = Object.fromEntries(
                Object.entries(params).filter(([key, value]) => value !== '')
            );

            // Build the query string
            const queryParams = new URLSearchParams(filteredParams).toString();

            try {
                const response = await fetch(`/api/files?${queryParams}`);

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Fetch failed with status: ${response.status} - ${errorText}`);
                }
                const data = await response.json();

                initializeDataTable(data);

            } catch (error) {
                console.error('Fetch operation error:', error.message || error);
                showToast({
                    type: 'danger',
                    message: 'failed! to fetch data.',

                });
            }
        }

        function initializeDataTable(data) {
            if (dataTable) {
                dataTable.destroy();
            }
            const customData = formData(data.data);
            const dataTableElement = document.getElementById("main-table");

            if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
                dataTable = new simpleDatatables.DataTable(dataTableElement, {
                    classes: {
                        loading: "datatable-loading text-sm",
                        dropdown: "datatable-perPage flex items-center",
                        selector: "per-page-selector px-2 py-1 border rounded border-gray-300 text-gray-600",
                        ellipsis: "datatable-ellipsis text-lg",
                        info: "datatable-info text-sm text-gray-500",
                        // pagination: "datatable-pagination",
                        // paginationList: "datatable-pagination-list",
                        search: "datatable-search",
                        input: "datatable-input",
                        top: "datatable-top",
                        bottom: "datatable-bottom",
                    },
                    data: customData,
                    paging: true,
                    nextPrev: true, // Enable previous and next buttons
                    pagerDelta: -6, // Show only one page number on each side of the current page
                    perPageSelect: [5, 10, 20, 50],
                    perPage: 5,
                    sortable: true,
                    searchable: true,
                    ellipsisText: '...',
                    labels: {
                        perPage: "<span class='text-gray-500 m-3'>Rows</span>",
                        searchTitle: "Search through table data",
                        placeholder: "Search...",
                    },
                    // tableRender: (_data, table, type) => {
                    //     if (type === "print") {
                    //         return table
                    //     }
                    //     const tHead = table.childNodes[0]
                    //     const filterHeaders = {
                    //         nodeName: "TR",
                    //         attributes: {
                    //             class: "search-filtering-row"
                    //         },
                    //         childNodes: tHead.childNodes[0].childNodes.map(
                    //             (_th, index) => ({
                    //                 nodeName: "TH",
                    //                 childNodes: [{
                    //                     nodeName: "INPUT",
                    //                     attributes: {
                    //                         class: "datatable-input",
                    //                         type: "search",
                    //                         "data-columns": "[" + index - "]"
                    //                     }
                    //                 }]
                    //             })
                    //         )
                    //     }
                    //     tHead.childNodes.push(filterHeaders)
                    //     return table
                    // },
                });

                tableEvents(data); // Custom function for handling events if required
            }
        }


        function tableEvents(data) {
            const events = ["init", "refresh", "page", "perpage", "update"];
            events.forEach(event => {
                dataTable.on(`datatable.${event}`, () => {
                    initializeDropdown(data);
                });
            });
        }

        function formData(data) {
            function formatDate(dateString) {
                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }; // Customize as needed
                return new Intl.DateTimeFormat('en-GB', options).format(new Date(dateString));
            }
            return {
                headings: ["File Name", "Office Source", "Date Modified", "Modified By",
                    "Classification",
                    "Actions"
                ],
                data: data.map(file => ({
                    cells: [
                        truncateFilename(file.file_name, 20),
                        file.office_source,
                        formatDate(file.updated_at),
                        file.user_name,
                        file.classification,
                        generateKebab(file.id, file.shared_users, file.file_name),
                    ],
                    attributes: {
                        class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize"
                    }
                }))
            };
        }

        // Generate action buttons for dropdowns
        function generateKebab(fileId, fileShared, fileName) {
            return `
        <button id="dropdownLeftButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        <div id="dropdownLeft${fileId}" class="hidden z-10 w-44 shadow-lg rounded-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 bg-white rounded-lg divide-y divide-gray-400">
                   <li class="relative">
            <a class="items-center w-full gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100 inline-flex"
                onclick="openFileModal(${fileId})">
                <i class='bx bxs-search-alt-2 absolute left-4 text-lg'></i>
                <span class="ml-7">View</span>
            </a>
        </li>
        <li class="relative">
            <a href="/api/files/download/${fileId}" target="_blank" class="flex items-center px-4 py-2 hover:bg-gray-100">
           <i class='bx bxs-folder-plus absolute left-4 text-lg'></i>
                <span class="ml-7">Download</span><!-- Text -->
            </a>
        </li>
        <li class="relative">
            <button class="toggle-btn w-full flex items-center gap-2 edit-button px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="edit" data-toggle-target="edit" aria-controls="section-edit"
                aria-expanded="false">
                <i class='bx bxs-pencil absolute left-4 text-lg'></i>
                <span class="ml-7">Edit</span>
            </button>
        </li>
        <li class="relative">
            <a class="toggle-btn move-button flex items-center gap-2 cursor-pointer px-4 py-2 hover:bg-gray-100 move-file-div"
                data-file-id="${fileId}" data-toggle-target="move" data-role="move" aria-controls="section-move" aria-expanded="false">
                <i class='bx bxs-share absolute left-4 text-lg'></i>
                <span class="ml-7">Move</span>
            </a>
        </li>
        <li class="relative">
            <a href="#" class="toggle-btn flex items-center gap-2 px-4 py-2 hover:bg-gray-100 share-file-link"
                data-file-id="${fileId}" data-role="share">
                <i class='bx bxs-cloud-upload absolute left-4 text-lg'></i>
                <span class="ml-7">Share</span>
            </a>
        </li>
        <li class="relative">
            <a class="toggle-btn w-full cursor-pointer text-left file-summary-button flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="summary" data-toggle-target="summary" aria-controls="section-summary"
                aria-expanded="false">
                <i class='bx bxs-file absolute left-4 text-lg'></i>
                <span class="ml-7">Summary</span>
            </a>
        </li>
         <li class="relative">
            <a class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100" href="/file-history/${fileId}">
               <i class='bx bxs-time absolute left-4 text-lg'></i>
                <span class="ml-7">History</span>
            </a>
        </li>
        <li class="relative">
            <a onclick="archiveFile(${fileId})" class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100">
                <i class='bx bxs-archive-in absolute left-4 text-lg'></i>
                <span class="ml-7">Archived</span>
            </a>
        </li>
            </ul>
        </div>
    `;
        }


        // Create dropdown for each file
        function createDropdown(fileId) {
            const dropdownButton = document.getElementById(`dropdownLeftButton${fileId}`);
            const dropdownElement = document.getElementById(`dropdownLeft${fileId}`);
            if (dropdownButton && dropdownElement) {
                new Dropdown(dropdownElement, dropdownButton, {
                    placement: 'left',
                    triggerType: 'click',
                    offsetSkidding: 0,
                    offsetDistance: 0,
                    ignoreClickOutsideClass: false,
                });
            }
        }

        function initializeDropdown(data) {
            data.data.forEach((file) => {
                createDropdown(file.id);
            });
        }
    </script> --}}
@endsection
