
const showUpload = document.getElementById("uploadBtn");
const exitButtonUpload = document.getElementById("close-upload-btn");
const exitButtonEdit = document.getElementById("close-edit-btn");
const mainTable = document.getElementById("mainTable");
const fileSection = document.getElementById("fileSection");
const fileSectionUploadFile = document.getElementById("upload-file");
const fileSectionEditFile = document.getElementById("edit-file");
// Show upload section
showUpload.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form

    // Show the file section and hide the main table
    mainTable.classList.remove("opacity-100");
    mainTable.classList.add("opacity-0");
    fileSectionUploadFile.classList.remove("hidden");
      
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
    // FetchAndPopulate();
    fileSection.classList.remove("opacity-100");
    fileSection.classList.add("opacity-0");
    // fileSectionUploadFile.classList.add("hidden");
    
    setTimeout(() => {
    fileSection.classList.add("hidden"); 
    mainTable.classList.remove("hidden");
    mainTable.classList.remove("opacity-0");
    mainTable.classList.add("opacity-100");
    }, 500);
});

exitButtonEdit.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form
    // FetchAndPopulate();
    fileSection.classList.remove("opacity-100");
    fileSection.classList.add("opacity-0");
    fileSectionEditFile.classList.add("hidden");

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
              // FetchAndPopulate();
                // Handle success (e.g., show a success message)
                loadingIcon.classList.add('hidden');
                buttonText.innerText = 'Submit'; 
             
                refreshDataTable();
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error (e.g., show an error message)
                loadingIcon.classList.add('hidden');
                buttonText.innerText = 'Submit'; // Reset button text
            }).finally(()=>{
                
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
        fileSectionFileSummary.classList.add("hidden");
        // Fetch the file data after the section is visible
        const response = await fetch(`/api/files/${fileId}?includePermit=false`);
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
        const response = await fetch(`/api/files/update/${selectedFileId}?hasPermit=false`, {
            method: 'POST', // or 'PUT' depending on your API design
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        });

        const data = await response.json();

        if (response.ok) {
            console.log('File updated successfully:', data);
            
                refreshDataTable();
            //FetchAndPopulate();
         
            // Handle success (e.g., show a success message or refresh the table)
        } else {
            console.error('Error updating file:', data.message);
        }

    } catch (error) {
        console.error('Fetch error:', error);
    }
})

 async function archiveFile(fileId) {
    const csrfToken = document.querySelector('input[name="_token"]').value;

    try {
        const response = await fetch(`/api/files/archived/${fileId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // CSRF token for security
            },
        });

        const result = await response.json();

        if (response.ok && result.success) {
             
                refreshDataTable();
            //alert('File archived successfully!');
            // Optionally, update the UI to show the file as archived
        } else {
            alert('Failed to archive the file.');
            console.error(result.message || 'Unknown error');
        }
    } catch (error) {
        console.error('Error archiving the file:', error);
        alert('An error occurred while archiving the file.');
    }
}

const fileSectionFileSummary = document.getElementById("file-summary");
async function  showFileSummary(fileId) {
     selectedFileId = fileId;
    // Assuming you want to perform some actions with the fileId, you can handle it here
    // e.g., populate the edit form with file data based on fileId
   
    mainTable.classList.remove("opacity-100");
    mainTable.classList.add("opacity-0");
    fileSectionFileSummary.classList.remove('hidden')
    
    

  
 setTimeout(async () => {
        mainTable.classList.add("hidden");
        fileSection.classList.remove("hidden");
        fileSection.classList.remove("opacity-0");
        fileSection.classList.add("opacity-100");
        fileSectionUploadFile.classList.add("hidden");
      
        // Fetch the file data after the section is visible
        const response = await fetch(`/api/files/${fileId}?includePermit=false`);
        const data = await response.json();

     
        if (response.ok) {
            const file = data.file;                            
                // Then set the values
                document.getElementById('view-office_source').value = file.office_source || '';
                document.getElementById('view-category').value = file.category || '';
                document.getElementById('view-classification').value = file.classification || '';
                document.getElementById('view-status').value = file.status || '';
        } else {
            console.error('Error:', data.message); // Handle the error accordingly
        }
    }, 300);       
}


const exitButtonFileSummary = document.getElementById("close-file-summary-btn");

exitButtonFileSummary.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default behavior if it's inside a form
    // FetchAndPopulate();
    fileSection.classList.remove("opacity-100");
    fileSection.classList.add("opacity-0");
    
    fileSectionFileSummary.classList.add("hidden");
    setTimeout(() => {
    fileSection.classList.add("hidden"); 
    mainTable.classList.remove("hidden");
    mainTable.classList.remove("opacity-0");
    mainTable.classList.add("opacity-100");
    }, 500);
});

const fileSectionFileRequest = document.getElementById("file-request");

function requestAccess(fileId, fileName) {
    
    const fileNameInput = document.getElementById("file-request_name");

    if (fileSectionFileRequest && fileNameInput) {
        fileSectionFileRequest.classList.remove("hidden");
        fileNameInput.value = fileName; 
        document.getElementById("request-file-id").value = fileId;
    
    } else {
        console.error("Modal or File Name Input not found");
    }
}

const exitButtonFileRequest = document.getElementById("close-file-request-btn");

exitButtonFileRequest.addEventListener("click", (event) => {
    event.preventDefault();    
   fileSectionFileRequest.classList.add("hidden");
})

document.getElementById("file-request-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get the file ID and user ID
    const fileId = document.getElementById("request-file-id").value; // Get file ID
    const userId = document.getElementById("request-user-id").value; // Get user ID from hidden input

    // Get other form values
    const requestedPermission = document.getElementById("category").value; // Get selected permission
    const remarks = document.getElementById("remarks").value; // Get remarks
    const csrfToken = document.querySelector('input[name="_token"]').value;
        
    // Create the request payload
    const requestData = {
        file_id: fileId,
        requested_by_user_id: userId, // Current user's ID
        requested_permission: requestedPermission,
        remarks: remarks
    };

    // Make the POST request using Fetch API
    fetch(`/api/files/request/${fileId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(requestData), // Convert requestData to JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Parse the JSON response
    })
    .then(data => {
        
        document.getElementById("file-request").classList.add("hidden"); // Hide the modal after success
    })
    .catch(error => {
        console.error('Error:', error);
    
    });
});



