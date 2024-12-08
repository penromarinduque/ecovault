@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="grid grid-cols-3 gap-6">
        <section class="col-span-1 space-y-6 bg-white p-6 border border-gray-200 rounded-lg shadow">

            <form class="max-w-md mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search client name" required />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                </div>
            </form>


            <form class="max-w-md mx-auto">

                <select id="large"
                    class="block w-full px-4 py-3 text-base text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option disabled selected hidden class="text-green-500">Select permit</option>
                    <option value="US">Tree Cutting Permits</option>
                    <option value="CA">Tree Plantation</option>
                    <option value="FR">Tree Transport Pemrit</option>
                    <option value="DE">Chainsaw Registration</option>
                    <option value="DE">Land Title</option>
                </select>
            </form>

            <form class="max-w-md mx-auto">
                <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                    <input id="bordered-checkbox-1" type="checkbox" value="" name="bordered-checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="bordered-checkbox-1"
                        class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Archived</label>
                </div>
            </form>


        </section>


        <section class="col-span-2">
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
                <div class="bg-white shadow-md rounded-lg p-4 hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold mb-2">Land Title 123.pdf</h3>
                    <p class="text-sm text-gray-600 mb-2"><strong>Owner:</strong> John Doe</p>


                    <!-- Modal toggle -->
                    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Toggle modal
                    </button>

                    <!-- Main modal -->
                    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Static modal
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="static-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        With less than a month to go before the European Union enacts new consumer privacy
                                        laws for its citizens, companies around the world are updating their terms of
                                        service agreements to comply.
                                    </p>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect
                                        on May 25 and is meant to ensure a common set of data rights in the European Union.
                                        It requires organizations to notify users as soon as possible of high-risk data
                                        breaches that could personally affect them.
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button data-modal-hide="static-modal" type="button"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                                        accept</button>
                                    <button data-modal-hide="static-modal" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    </div>

    <script>
        function toggleDetails(button) {
            const details = button.nextElementSibling;
            if (details.classList.contains("hidden")) {
                details.classList.remove("hidden");
                button.textContent = "Hide Details";
            } else {
                details.classList.add("hidden");
                button.textContent = "Show Details";
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
