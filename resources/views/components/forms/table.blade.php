<div class="overflow-x-auto bg-white rounded-lg p-5 h-[480px]">
    <table id="main-table">
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        fetch('/api/files-without-relationships')
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
                        data: data.files.map((file) => ({
                            cells: [
                                file.file_name,
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
                                        <li><a href="/api/files/${file.id}" class="block px-4 py-2 hover:bg-gray-100">View</a></li>
                                        <li><a href="#" class="block px-4 py-2  hover:bg-gray-100">Download</a></li>
                                        <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">Edit</button></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Share</a></li>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">File Summary</a></li>
                                    </ul>
                                </div>`
                            ],
                            attributes: {
                                class: "text-gray-700 text-left hover:bg-gray-100"
                            }
                        })),
                    };

                    // Initialize the DataTable with options
                    const dataTableElement = document.getElementById("main-table");
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
                            perPageSelect: false,
                            sortable: true,
                            perPage: 5, // set the number of rows per page
                            perPageSelect: [5, 10, 20, 50],
                            data: customData
                        });


                    function initializeDropdowns() {
                        data.files.forEach((file) => {
                            const dropdownButton = document.getElementById(
                                `dropdownLeftButton${file.id}`);
                            const dropdownElement = document.getElementById(`dropdownLeft${file.id}`);
                            // Options with default values for the dropdown
                            const options = {
                                placement: 'left',
                                triggerType: 'click',
                                offsetSkidding: 0,
                                offsetDistance: 0,
                                ignoreClickOutsideClass: false,
                            };

                            // Initialize the Dropdown for each file
                            new Dropdown(dropdownElement, dropdownButton, options);
                        });
                    }

                    // Listen to events that indicate table content updates
                    dataTable.on("datatable.page", initializeDropdowns);
                    dataTable.on("datatable.update",
                        initializeDropdowns);

                    // Initial call for dropdowns in the first page
                    initializeDropdowns(data);
                }
            })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });
    });
</script>
