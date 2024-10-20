const showUpload = document.getElementById("uploadBtn");
const exitButton = document.getElementById("close-upload-btn");
const mainTable = document.getElementById("mainTable");
const fileSection = document.getElementById("fileSection");

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
exitButton.addEventListener("click", (event) => {
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



