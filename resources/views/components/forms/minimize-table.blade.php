<!-- When there is no desire, all things are at peace. - Laozi -->
<table id="minimize-table">
    <!-- Table Headers will be dynamically generated -->
</table>


<script>
    //love what you are doing
    let minidataTable;

    let reports = {!! json_encode($record ?? '') !!};

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
            type: types || '',
            municipality: municipalities || '',
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
        ? ` <li class="relative">
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
            <a class="toggle-btn w-full cursor-pointer text-left file-summary-button flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="summary" data-toggle-target="summary" aria-controls="section-summary"
                aria-expanded="false">
                <i class='bx bxs-file absolute left-4 text-lg'></i>
                <span class="ml-7">Summary</span>
            </a>
        </li>
        `
        : `
        <li><button onclick="requestAccess(${fileId}, '${fileName}')" class="block px-4 py-2 hover:bg-gray-100">Request Access</button></li>
        `}
    `;

        const adminActions = `
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
            <a class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100">
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
    `;

        // Choose the correct actions based on isAdmin
        const actions = isAdmin ? adminActions : employeeActions;

        return `
        <button id="dropdownRightButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        <div id="dropdownRight${fileId}" class="hidden z-10 w-44 shadow-lg rounded-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 bg-white rounded-lg divide-y divide-gray-400">
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
