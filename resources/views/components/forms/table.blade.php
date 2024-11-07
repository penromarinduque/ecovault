<table id="main-table">
    <!-- Table Headers will be dynamically generated -->
</table>


<script>
    //love what you are doing
    let dataTable;
    const isAdmin = {!! json_encode($isAdmin) !!};
    let type = {!! json_encode($type) !!};
    let municipality = {!! json_encode($municipality) !!};
    let isArchived = false;
    document.addEventListener("DOMContentLoaded", function() {

        // Define parameters for the request


        const params = {
            type: type,
            municipality: municipality,
            report: '',
            isArchived: isArchived
        };

        // Remove empty parameters
        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );

        // Build the query string
        const queryParams = new URLSearchParams(filteredParams).toString();

        // Initial data fetch
        fetchData(queryParams);

    });

    // Function to fetch data and initialize or update the DataTable
    async function fetchData(queryParams) {
        try {
            const response = await fetch(`/api/files?${queryParams}`);

            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Fetch failed with status: ${response.status} - ${errorText}`);
            }

            const data = await response.json();
            if (dataTable) {
                dataTable.destroy(); // Clear the existing table
            }
            const customData = {
                headings: ["Name", "Office Source", "Date Modified", "Modified By", "Category",
                    "Classification", "Status", "Actions"
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
                        generateKebab(file.id)
                    ],
                    attributes: {
                        class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize"
                    }
                }))
            };

            const dataTableElement = document.getElementById("main-table");

            if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
                // Recreate the DataTable instance with the new data
                dataTable = new simpleDatatables.DataTable(dataTableElement, {
                    classes: {
                        dropdown: "datatable-perPage flex items-center",
                        selector: "per-page-selector px-2 py-1 border rounded text-gray-600",
                        info: "datatable-info text-sm text-gray-500",
                    },
                    labels: {
                        perPage: "<span class='text-gray-500 m-3'>Rows</span>",
                        searchTitle: "Search through table data",
                    },
                    searchable: true,
                    perPageSelect: true,
                    sortable: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 20, 50],
                    data: customData
                });

                // Initialize dropdowns for the current page
                initializeDropdowns(data);

                // Listen for pagination events
                dataTable.on("datatable.page", () => {
                    initializeDropdowns(data); // Re-initialize dropdowns on page change
                });
            }
        } catch (error) {
            console.error('Fetch operation error:', error.message || error);
            alert('Failed to fetch data. Please try again.');
        }
    }


    // Generate action buttons for dropdowns
    function generateKebab(fileId) {
        const commonActions = `
        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
        <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
        <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</button></li>
        <li><button onclick="archiveFile(${fileId})" class="block px-4 py-2 hover:bg-gray-100">Request Access</button></li>
    `;

        const adminActions = `
        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
        <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
        <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">Edit</button></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
        <li><button class="block px-4 py-2 hover:bg-gray-100" onclick="fileShare(${fileId})">Share</button></li>
        <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</button></li>
        <li><button onclick="archiveFile(${fileId})" class="block px-4 py-2 hover:bg-gray-100">Archive</button></li>
    `;

        // Choose the correct actions based on isAdmin
        const actions = isAdmin ? adminActions : commonActions;

        return `
        <button id="dropdownLeftButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        <div id="dropdownLeft${fileId}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
                ${actions}
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

    function initializeDropdowns(data) {
        data.data.forEach((file) => {
            createDropdown(file.id);
        });
    }
    // Refresh data after CRUD operation
    function updateTable() {
        // Define parameters for the request
        const params = {
            type: type,
            municipality: municipality,
            report: '',
            isArchived: isArchived
        };

        // Remove empty parameters
        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );

        // Build the query string
        const newParams = new URLSearchParams(filteredParams).toString();

        // Destroy the existing DataTable instance if it exists
        if (dataTable && typeof dataTable.destroy === "function") {
            dataTable.destroy();
            dataTable = null;

        }

        // Fetch new data with the queryParams
        fetchData(newParams);
    }

    window.updateTable = updateTable;
</script>
