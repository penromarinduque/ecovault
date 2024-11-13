<!-- When there is no desire, all things are at peace. - Laozi -->
<table id="minimize-table">
    <!-- Table Headers will be dynamically generated -->
</table>


<script>
    //love what you are doing
    let minidataTable;

    let reports = {!! json_encode($record ?? []) !!};

    let isAdmins = {!! json_encode($isAdmin) !!};
    let types = {!! json_encode($type) !!};
    let municipalities = {!! json_encode($municipality) !!};
    let isArchives = {!! json_encode($isArchived) !!};

    document.addEventListener("DOMContentLoaded", function() {
        // Define parameters for the request
        fetchDatas();

    });

    async function fetchDatas() {
        const params = {
            type: types,
            municipality: municipalities,
            report: reports || '',
            isArchived: isArchives
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

            initializeTables(data);

        } catch (error) {
            console.error('Fetch operation error:', error.message || error);
            alert('Failed to fetch data. Please try again.');
        }
    }

    function initializeTables(data) {
        if (minidataTable) {
            minidataTable.destroy();
        }
        const customData = formDatas(data.data);
        const dataTableElement = document.getElementById("minimize-table");

        if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
            minidataTable = new simpleDatatables.DataTable(dataTableElement, {
                classes: {
                    loading: "datatable-loading text-sm",
                    dropdown: "datatable-perPage flex items-center",
                    selector: "per-page-selector px-2 py-1 border rounded text-gray-600",
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
            });

            tableEvent(data); // Custom function for handling events if required
        }
    }

    function tableEvent(data) {
        const events = ["init", "refresh", "page", "perpage", "update"];
        events.forEach(event => {
            minidataTable.on(`datatable.${event}`, () => {
                initializeDropdown(data);
            });
        });
    }

    function formDatas(data) {
        return {
            headings: ["Name", "Actions"],
            data: data.map(file => ({
                cells: [
                    file.file_name.length > 15 ?
                    file.file_name.substring(0, 15) + '...' :
                    file.file_name, // Truncate file name if longer than 15 character
                    generateKebabs(file.id, file.shared_users, file.file_name),
                ],
                attributes: {
                    class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize"
                }
            }))
        };
    }

    // Generate action buttons for dropdowns
    function generateKebabs(fileId, fileShared, fileName) {
        const employeeActions = `
        ${fileShared.includes({{ auth()->user()->id }}) || isAdmin
        ? `
        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
        <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
        <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</button></li>
        `
        : `
        <li><button onclick="requestAccess(${fileId}, '${fileName}')" class="block px-4 py-2 hover:bg-gray-100">Request Access</button></li>
        `}
    `;

        const adminActions = `
        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
        <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
        <li><button class="w-full text-left edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">Edit</button></li>
        <li><a class="block cursor-pointer px-4 py-2 hover:bg-gray-100 move-file-div" data-file-id="${fileId}">Move</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 share-file-link" data-file-id="${fileId}">Share</a></li>
        <li><a class="w-full cursor-pointer text-left file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</a></li>
        <li><a onclick="archiveFile(${fileId})" class="block px-4 py-2 cursor-pointer hover:bg-gray-100">Archive</a></li>
    `;

        // Choose the correct actions based on isAdmin
        const actions = isAdmin ? adminActions : employeeActions;

        return `
        <button id="dropdownRightButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        <div id="dropdownRight${fileId}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
                ${actions}
            </ul>
        </div>
    `;
    }


    // Create dropdown for each file
    function createDropdowns(fileId) {
        const dropdownButton = document.getElementById(`dropdownRightButton${fileId}`);
        const dropdownElement = document.getElementById(`dropdownRight${fileId}`);
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
            createDropdowns(file.id);
        });
    }
</script>
