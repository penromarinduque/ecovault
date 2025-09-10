<table id="main-table">
    <!-- Table Headers will be dynamically generated -->
</table>


<script>
    //love what you are doing
    let dataTable;

    let report = {!! json_encode($record ?? '') !!};
    let isAdmin = {!! json_encode($isAdmin) !!};
    let type = {!! json_encode($type ?? '') !!};
    let municipality = {!! json_encode($municipality ?? '') !!};
    let category = {!! json_encode($category ?? '') !!};
    let isArchived = {!! json_encode($isArchived) !!};

    document.addEventListener("DOMContentLoaded", function() {
        // Define parameters for the request
        fetchData();

    });

    async function fetchData() {

        const params = {
            type: type,
            municipality: municipality,
            report: report,
            category: category,
            isArchived: isArchived
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

            if(type === 'local-transport-permit') {
                // Check if the user is an admin
                const excludeOfficeSource = true;
                initializeTable(data, excludeOfficeSource);
            } else {
                initializeTable(data);
            }
            // initializeTable(data, excludeOfficeSource);

        } catch (error) {
            console.log('Fetch operation error:', error);
            console.log('adasdasd')
            showToast({
                type: 'danger',
                message: 'failed! to fetch data.',

            });
        }
    }

    function initializeTable(data, excludeOfficeSource = false) {
        if (dataTable) {
            dataTable.destroy();
        }
        const customData = formData(data.data, excludeOfficeSource);
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
                initializeDropdowns(data);
            });
        });
    }

   function formData(data, excludeOfficeSource = false) {
    function formatDate(dateString) {
        const options = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }; // Customize as needed
        return new Intl.DateTimeFormat('en-GB', options).format(new Date(dateString));
    }

    // Define headings dynamically
    const headings = excludeOfficeSource
        ? ["File Name", "Date Modified", "Modified By", "Classification", "Actions"]
        : ["Title", "Control No.", "Date", "Actions"];
    // Map data dynamically
    const dataRows = data.map(file => {
        const cells = excludeOfficeSource
            ? [
                truncateFilename(file.file_name, 20),
                formatDate(file.updated_at),
                file.user_name,
                file.classification,
                generateKebab(file.id, file.shared_users, file.file_name),
            ]
            : [
                truncateFilename(file.file_name, 20),
                file.control_no,
                formatDate(file.created_at),
                generateKebab(file.id, file.shared_users, file.file_name),
            ];

        return {
            cells: cells,
            attributes: {
                class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize"
            }
        };
    });

    return {
        headings: headings,
        data: dataRows
    };
}

    // Generate action buttons for dropdowns
    function generateKebab(fileId, fileShared, fileName) {
        const employeeActions = `
        ${fileShared.includes({{ auth()->user()->id }}) || isAdmin
        ? `
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
            <a class="toggle-btn w-full cursor-pointer text-left file-summary-button flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="summary" data-toggle-target="summary" aria-controls="section-summary"
                aria-expanded="false">
                <i class='bx bxs-file absolute left-4 text-lg'></i>
                <span class="ml-7">Summary</span>
            </a>
        </li>
        `
        : `
         <li class="relative">
            <a onclick="requestAccess(${fileId}, '${fileName}')" class="toggle-btn w-full cursor-pointer text-left file-request-button flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="request" data-toggle-target="request" aria-controls="section-request"
                aria-expanded="false">
                <i class='bx bxs-user-check absolute left-4 text-2xl'></i>
                <span class="ml-7">Request Access</span>
            </a>
        </li>
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
            <a class="toggle-btn w-full cursor-pointer text-left rename-button flex items-center gap-2 px-4 py-2 hover:bg-gray-100"
                data-file-id="${fileId}" data-role="rename" data-toggle-target="rename" aria-controls="section-rename"
                aria-expanded="false">
                <i class='bx bxs-edit absolute left-4 text-lg'></i>
                <span class="ml-7">Rename</span>
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
           ${
            isArchived
            ? `<a onclick="unarchiveFile(${fileId})" class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100">
                <i class='bx bxs-archive-out absolute left-4 text-lg'></i>
                <span class="ml-7">Unarchive</span>
            </a>`
            : `<a onclick="archiveFile(${fileId})" class="flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-gray-100">
                <i class='bx bxs-archive-in absolute left-4 text-lg'></i>
                <span class="ml-7">Archive</span>
            </a>`
        }
        </li>
    `;

        // Choose the correct actions based on isAdmin
        const actions = isAdmin ? adminActions : employeeActions;

        return `
        <button id="dropdownLeftButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        <div id="dropdownLeft${fileId}" class="hidden z-10 w-44 shadow-lg rounded-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 bg-white rounded-lg divide-y divide-gray-400">
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
</script>
