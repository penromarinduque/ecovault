//love what you are doing
let dataTable;

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
    console.log("Starting data fetch with parameters:", queryParams); // Log params
    
    try {
        const response = await fetch(`/api/files?${queryParams}`);
        
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Fetch failed with status: ${response.status} - ${errorText}`);
        }
        
        const data = await response.json();
        console.log("Fetched data:", data); // Log data to confirm structure

        const customData = {
            headings: ["Name", "Office Source", "Date Modified", "Modified By", "Category", "Classification", "Status", "Actions"],
            data: data.data.map((file) => ({
                cells: [
                    file.file_name,
                    file.office_source,
                    file.updated_at,
                    file.user_name,
                    file.category,
                    file.classification,
                    file.status,
                    generateActionButtons(file.id)
                ],
                attributes: { class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize" }
            }))
        };

        const dataTableElement = document.getElementById("sorting-table");
        
        if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
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
function generateActionButtons(fileId) {
    console.log('Function called with fileId:', isAdmin); // Log to see what values are passed
    // Use the isAdmin variable directly
    return `
        <button id="dropdownLeftButton${fileId}" class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </button>
        ${isAdmin ? `
        <div id="dropdownLeft${fileId}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
                <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
                <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
                <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">Edit</button></li>
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
                <li><button id="defaultModalButton${fileId}" data-modal-target="defaultModal${fileId}" data-modal-toggle="defaultModal${fileId}" class="block px-4 py-2 hover:bg-gray-100">Share</button></li>
                <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</button></li>
                <li><button onclick="archiveFile(${fileId})" class="block px-4 py-2 hover:bg-gray-100">Archive</button></li>
            </ul>
        </div>
        ` : `
        <div id="dropdownLeft${fileId}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
            <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
                <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${fileId})">View</a>
                <li><a href="/api/files/download/${fileId}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
                <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">Edit</button></li>
                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Request Access</a></li>
                <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${fileId}">File Summary</button></li>
                <li><button onclick="archiveFile(${fileId})" class="block px-4 py-2 hover:bg-gray-100">Archive</button></li>
            </ul>
        </div>
        `}
    `;
}

function sharinngDropdown(fileId){
    return   ``
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
async function updateDataAfterCRUD() {
    console.log("Updating data after CRUD operation...");

    // Define parameters for the request
    const params = {
        type: permitType,
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

    // Check if dataTable exists and has the destroy method
    if (dataTable && typeof dataTable.destroy === "function") {
        dataTable.destroy(); // Destroy the existing DataTable instance
        dataTable = null; // Set dataTable to null after destruction
    }

    // Fetch new data with the queryParams
    await fetchData(queryParams); // Pass queryParams
    console.log("DataTable display has been refreshed!");
}



window.updateDataAfterCRUD = updateDataAfterCRUD;
 // Close DOMContentLoaded function
// Archive file function
async function archiveFile(fileId) {
    const csrfToken = document.querySelector('input[name="_token"]').value;

    try {
        const response = await fetch(`/api/files/archived/${fileId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        });
        const result = await response.json();
        if (response.ok && result.success) {
            updateDataAfterCRUD();
        } else {
            alert('Failed to archive the file.');
            console.error(result.message || 'Unknown error');
        }
    } catch (error) {
        console.error('Error archiving the file:', error);
        alert('An error occurred while archiving the file.');
    }
}

// Toggle sections
function toggleSections(showFileSection) {
    const mainTable = document.getElementById('mainTable');
    const fileSection = document.getElementById('fileSection');
    if (showFileSection) {
        mainTable.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            mainTable.classList.add('pointer-events-none', 'hidden');
            fileSection.classList.replace('opacity-0', 'opacity-100');
            fileSection.classList.remove('hidden', 'pointer-events-none');
        }, 300);
    } else {
        fileSection.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            fileSection.classList.add('pointer-events-none', 'hidden');
            mainTable.classList.replace('opacity-0', 'opacity-100');
            mainTable.classList.remove('hidden', 'pointer-events-none');
        }, 300);
    }
}

// Show/hide div sections
function toggleDivVisibility(showDivId) {
    const sections = ['upload-file-div', 'edit-file-div', 'file-summary-div'];
    sections.forEach(section => {
        const sectionDiv = document.getElementById(section);
        sectionDiv.classList.toggle('hidden', section !== showDivId);
    });
}

// Event listeners for buttons
document.getElementById('uploadBtn').addEventListener('click', () => {
    toggleSections(true);
    toggleDivVisibility('upload-file-div');
});
document.body.addEventListener('click', (event) => {
    if (event.target.matches('.edit-button')) {
        toggleSections(true);
        const fileId = event.target.dataset.fileId;
        fetchFileData(fileId);
        toggleDivVisibility('edit-file-div');
    }
});
document.body.addEventListener('click', (event) => {
    if (event.target.matches('.file-summary-button')) {
        toggleSections(true);
        const fileId = event.target.dataset.fileId;
        fetchFileDetails(fileId);
        toggleDivVisibility('file-summary-div');
    }
});

// Close buttons in the file section
document.getElementById('close-upload-btn').addEventListener('click', () => toggleSections(false));
document.getElementById('close-edit-btn').addEventListener('click', () => toggleSections(false));
document.getElementById('close-summary-btn').addEventListener('click', () => toggleSections(false));

//edit js



// This script fetches file data when an edit button is clicked



