// // // // Table Function

 function FetchAndPopulate() {

    

  
        // PHP variable inside JavaScript
        fetch(`/api/files-without-relationships/${record}`)
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
                            "Office Source",
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
                                file.office_source,
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
                                         <a href="#" class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}" onclick="showEditFile('${file.id}')">Edit</a>                                                                                                                                                                                                                                             
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
                                    `<div class='${options.classes.top}'>
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
                            </div>`,
                          
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
                            const dropdownElement = document.getElementById(
                                `dropdownLeft${file.id}`);
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
    }

    document.addEventListener('DOMContentLoaded', () => {
        FetchAndPopulate();
    });








///
const showUpload = document.getElementById("uploadBtn");
const exitButtonUpload = document.getElementById("close-upload-btn");
const exitButtonEdit = document.getElementById("close-edit-btn");
const mainTable = document.getElementById("mainTable");
const fileSection = document.getElementById("fileSection");
const fileSectionUploadFile = document.getElementById("upload-file");
// Show upload section
showUpload.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form

    // Show the file section and hide the main table
    mainTable.classList.remove("opacity-100");
    mainTable.classList.add("opacity-0");

    // Wait for the opacity transition to finish before hiding
    setTimeout(() => {
    mainTable.classList.add("hidden"); // Hide main table
    fileSection.classList.remove("hidden");
    fileSection.classList.remove("opacity-0");
    fileSection.classList.add("opacity-100");
    }, 500); // Match this to the duration of your CSS transition
});

// Exit file section
exitButtonUpload.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form

    fileSection.classList.remove("opacity-100");
    fileSection.classList.add("opacity-0");


    setTimeout(() => {
    fileSection.classList.add("hidden"); 
    mainTable.classList.remove("hidden");
    mainTable.classList.remove("opacity-0");
    mainTable.classList.add("opacity-100");
    }, 500);
});

exitButtonEdit.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form

    fileSection.classList.remove("opacity-100");
    fileSection.classList.add("opacity-0");


    setTimeout(() => {
    fileSection.classList.add("hidden"); 
    mainTable.classList.remove("hidden");
    mainTable.classList.remove("opacity-0");
    mainTable.classList.add("opacity-100");
    }, 500);
});


 document.getElementById('upload-form').addEventListener('submit', function(event) {
        event.preventDefault(); 
         const fileUploadError = document.getElementById('file-upload-error');
        const officeSource = document.getElementById('office_source').value;
        const category = document.getElementById('category').value;
        const classification = document.getElementById('classification').value;
        const status = document.getElementById('status').value;
        const fileInput = document.getElementById('file-upload');
        const reportType = document.getElementById("report_type").value;
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        
        // Reset error message visibility
        fileUploadError.classList.add('invisible');

     const validFileTypes = [
    'application/zip', 
    'application/msword', // DOC
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
    'application/pdf' // PDF
    ];

        const file = fileInput.files[0];

    if (!file) {
        fileUploadError.textContent = 'Please choose a file to upload.';
        fileUploadError.classList.remove('invisible');
        return; // Exit if no file is chosen
    } 

    // Check the MIME type first
    const isValidType = validFileTypes.includes(file.type);

    // Additionally check the file extension for better accuracy
    const validExtensions = ['zip', 'doc', 'docx', 'pdf'];
    const fileExtension = file.name.split('.').pop().toLowerCase();
    const isValidExtension = validExtensions.includes(fileExtension);

    if (!isValidType && !isValidExtension) {
        fileUploadError.textContent = 'Invalid file type. Only .zip, .doc, .docx, and .pdf files are allowed.';
        fileUploadError.classList.remove('invisible');
        return; // Exit if the file type is invalid
    }

            // Prepare form data to send via AJAX
            const formData = new FormData(this);
            formData.append('report_type', reportType);
            // Optionally show loading state
            const loadingIcon = document.getElementById('loading-icon');
            const buttonText = document.getElementById('button-text');
            loadingIcon.classList.remove('hidden');
            buttonText.innerText = 'Uploading...';

            // Send the form data using fetch
            fetch('/file-upload', { // Replace with your endpoint
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Assuming your response is JSON
            })
            .then(data => {
                console.log('Success:', data);
                // Handle success (e.g., show a success message)
                loadingIcon.classList.add('hidden');
                buttonText.innerText = 'Submit'; // Reset button text
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error (e.g., show an error message)
                loadingIcon.classList.add('hidden');
                buttonText.innerText = 'Submit'; // Reset button text
            });
            
    });

function validateForm() {
    let isValid = true;


    

    // Get all fields
    const officeSource = document.getElementById("edit-office_source");
    const category = document.getElementById("edit-category");
    const classification = document.getElementById("edit-classification");
    const status = document.getElementById("edit-status");


const fileInput = document.getElementById("file-upload");
    const fileError = document.getElementById("file-upload-error");

    // Check if a file is selected
    if (!fileInput.files.length) {
        fileError.classList.remove("invisible"); // Show the error
        isValid = false;
    } else {
        fileError.classList.add("invisible"); // Hide the error
    }


    // Validate Office Source
    if (!officeSource.value.trim()) {
        showError('office-source-error');
        isValid = false;
    } else {
        hideError('office-source-error');
    }

    // Validate Category
    if (!category.value.trim()) {
        showError('category-error');
        isValid = false;
    } else {
        hideError('category-error');
    }

    // Validate Classification
    if (!classification.value.trim()) {
        showError('classification-error');
        isValid = false;
    } else {
        hideError('classification-error');
    }

    // Validate Status
    if (!status.value.trim()) {
        showError('status-error');
        isValid = false;
    } else {
        hideError('status-error');
    }

    // Validate file input
    if (!fileInput.files.length) {
        document.getElementById("file-upload-error").classList.remove("invisible");
        isValid = false;
    } else {
        document.getElementById("file-upload-error").classList.add("invisible");
    }

    // Return validation status
    return isValid;
}

function showError(elementId) {
    document.getElementById(elementId).style.opacity = 1;
}

function hideError(elementId) {
    document.getElementById(elementId).style.opacity = 0;
}

function updateFileName() {
    const fileInput = document.getElementById('file-upload');
    const fileNameElement = document.getElementById('file-upload-name');
    const file = fileInput.files[0];

    if (file) {
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop();
        const baseName = fileName.substring(0, fileName.lastIndexOf('.'));
        
        let displayName = baseName;

        // Shorten base name if it's too long
        if (baseName.length > 10) {
            displayName = baseName.substring(0, 7) + '...' + baseName.slice(-3);
        }

        // Display shortened name with extension
        fileNameElement.textContent = displayName + '.' + fileExtension;
        document.getElementById('file-upload-error').classList.add('invisible'); // Hide the error once a file is selected
    } else {
        fileNameElement.textContent = "No file chosen";
        document.getElementById('file-upload-error').classList.remove('invisible'); // Show error if no file
    }
}

const fileSectionEditFile = document.getElementById("edit-file");

const editOfficeSource = document.getElementById("edit-office_source");
const editCategory = document.getElementById("edit-category");
const editClassification = document.getElementById("edit-classification");
const editStatus = document.getElementById("edit-status");
let selectedFileId;
async function  showEditFile(fileId) {
     selectedFileId = fileId;
    // Assuming you want to perform some actions with the fileId, you can handle it here
    // e.g., populate the edit form with file data based on fileId
    fileSectionEditFile.classList.remove('hidden'); // Show the div
    mainTable.classList.remove("opacity-100");
    mainTable.classList.add("opacity-0");

    // Wait for the opacity transition to finish before hiding
 setTimeout(async () => {
        mainTable.classList.add("hidden");
        fileSection.classList.remove("hidden");
        fileSection.classList.remove("opacity-0");
        fileSection.classList.add("opacity-100");
        fileSectionUploadFile.classList.add("hidden");

        // Fetch the file data after the section is visible
        const response = await fetch(`/api/file-only/${fileId}`);
        const data = await response.json();

        if (response.ok) {
            const file = data.file;
             document.getElementById('edit-office_source').value = file.office_source || '';
            document.getElementById('edit-category').value = file.category || '';
            document.getElementById('edit-classification').value = file.classification || '';
            document.getElementById('edit-status').value = file.status || '';


        } else {
            console.error('Error:', data.message); // Handle the error accordingly
        }
    }, 300);

       
}


document.getElementById('edit-form').addEventListener('submit', async function(event) {
        event.preventDefault(); 

        try {
        // Create a new FormData object
        const formData = new FormData();

        // Get form input values and append them to the form data
        const officeSourceInput = document.getElementById('edit-office_source');
        const categorySelect = document.getElementById('edit-category');
        const classificationInput = document.getElementById('edit-classification');
        const statusInput = document.getElementById('edit-status');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        // Append the values to formData
        formData.append('office_source', officeSourceInput.value || '');
        formData.append('category', categorySelect.value || '');
        formData.append('classification', classificationInput.value || '');
        formData.append('status', statusInput.value || '');
        
        // Send the form data to your API for updating the file
        const response = await fetch(`/api/file-only/update/${selectedFileId}`, {
            method: 'POST', // or 'PUT' depending on your API design
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        });

        const data = await response.json();

        if (response.ok) {
            console.log('File updated successfully:', data);
            // Handle success (e.g., show a success message or refresh the table)
        } else {
            console.error('Error updating file:', data.message);
        }

    } catch (error) {
        console.error('Fetch error:', error);
    }
})