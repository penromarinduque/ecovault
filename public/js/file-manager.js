//love what you are doing


//Refresh Table In every activity upload/edit/archiving/etc
function refreshTable() {
    fetchData();
    fetchDatas();
}


// Get references to containers
const sectionContainer = document.getElementById('section-container');
const tableContainer = document.getElementById('table-container');
const closeAllBtns = document.querySelectorAll('.close-all-btn'); // Select all close buttons by class
const sectionAnimation = document.getElementById('section-animation');
// Function to toggle sections
function toggleSection(sectionId) {
    // Hide all sections first
    sectionContainer.querySelectorAll('.section').forEach(section => section.classList.add('hidden'));

    // Show the selected section
    const targetSection = document.getElementById(`${sectionId}-section`);
    if (targetSection) {
        sectionAnimation.classList.add('animate-slideIn');
        targetSection.classList.remove('hidden');
    }

    sectionContainer.classList.remove('hidden'); // Show parent container
    tableContainer.classList.add('hidden'); // Hide table container

    // Update aria-expanded attributes for buttons
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.setAttribute('aria-expanded', button.dataset.toggleTarget === sectionId ? 'true' : 'false');
    });

    // If no sections are visible, hide parent container
    if (!sectionContainer.querySelector('.section:not(.hidden)')) {
        sectionContainer.classList.add('hidden');
        tableContainer.classList.remove('hidden'); // Show table container
    }
}

// Function to close all sections and return to table view
function closeAllSections() {
    // Start fade-out animation
    sectionAnimation.classList.remove('animate-slideIn'); // Remove any active slide-in
    sectionAnimation.classList.add('animate-fadeOut');
    // Wait for fade-out to complete
    sectionAnimation.addEventListener(
        'animationend',
        () => {
            sectionContainer.querySelectorAll('.section').forEach(section => section.classList.add('hidden')); // Hide sections
            sectionContainer.classList.add('hidden'); // Hide parent container
            tableContainer.classList.remove('hidden'); // Show table container
            sectionAnimation.classList.remove('animate-fadeOut'); // Clean up animation class
        },
        { once: true }
    );
}
// Global event listener for all toggle buttons
document.addEventListener('click', event => {
    const button = event.target.closest('.toggle-btn');
    if (button) {
        const sectionId = button.dataset.toggleTarget;
        const fileId = button.dataset.fileId;
        const role = button.dataset.role;//logic by harvey select the role of button base on dataset.



        if (fileId) {
            console.log('File ID:', fileId);
            console.log(role);
            switch (role) {
                case 'edit':
                    fetchEditFile(fileId);
                    break;

                case 'summary':
                    fetchFileSummary(fileId);
                    break;
                case 'share':
                    fileShare(fileId);
                    break;
                case 'move':
                    fetchFileDataMove(fileId);   
                    break;
                case 'rename':
                    renameFile(fileId);
                    break;
            }

        }

        if (button.classList.contains("close-all-btn")) {

            switch (role) {
                case 'upload':
                    const specification = document.querySelectorAll('.file-specification-box');
                    const uploadForm = document.getElementById("upload-form");

                    if (uploadForm) {
                        uploadForm.reset();
                        showToast({
                            type: 'default',
                            message: 'Exit upload. File input has been reset.',

                        });
                    }

                    if (specification) {
                        specification.forEach(template => {
                            template.remove();
                        });
                    }
                    break;

                case 'edit':
                        showToast({
                            type: 'default',
                            message: 'Edit has been canceled.',

                        });
                    break;

            }

            closeAllSections(); // Close all sections when "Close All" button is clicked
        } else {
            toggleSection(sectionId); // Toggle the respective section
        }
    }
});


function truncateFilename(filename, maxLength) {
    const parts = filename.split('.');
    if (parts.length < 2) {
        return filename; // No extension, return the filename as is
    }

    const name = parts.slice(0, -1).join('.'); // The main part of the filename
    const extension = parts[parts.length - 1]; // The file extension

    if (filename.length <= maxLength) {
        return filename; // No truncation needed
    }

    // Calculate the length for the truncated name
    const keepLength = maxLength - extension.length - 3; // 3 is for the "..."
    if (keepLength <= 0) {
        return `...${extension}`; // If there's no space for the name, just show the extension
    }

    // Truncate the name and return the result
    return name.substring(0, keepLength) + '...' + extension;
}
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
            console.log('succccc')

            refreshTable();

            showToast({
                type: 'success',
                message: 'File successfully moved to the archive.',

            });

        } else {
            showToast({
                type: 'danger',
                message: 'An error occurred while archiving the file.',

            });

        }
    } catch (error) {
        showToast({
            type: 'danger',
            message: 'An error occurred while archiving the file.',

        });

    }
}

async function unarchiveFile(fileId) {
    const csrfToken = document.querySelector('input[name="_token"]').value;

    try {
        const response = await fetch(`/api/files/unarchived/${fileId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        });
        const result = await response.json();
        if (response.ok && result.success) {
            console.log('succccc')

            refreshTable();

            showToast({
                type: 'success',
                message: 'File successfully unarchived.',

            });

        } else {
            showToast({
                type: 'danger',
                message: 'An error occurred while unarchiving the file.',

            });

        }
    } catch (error) {
        showToast({
            type: 'danger',
            message: 'An error occurred while archiving the file.',

        });

    }
}


// Rename file function
async function renameFile(fileId) {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    const newFileName = prompt("Enter the new file name:");

    if (!newFileName) {
        showToast({
            type: 'danger',
            message: 'Rename operation canceled. No new file name provided.',
        });
        return;
    }

    try {
        const response = await fetch(`/api/files/rename/${fileId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ new_name: newFileName }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            refreshTable();
            showToast({
                type: 'success',
                message: 'File renamed successfully.',
            });
        } else {
            showToast({
                type: 'danger',
                message: result.message || 'An error occurred while renaming the file.',
            });
        }
    } catch (error) {
        showToast({
            type: 'danger',
            message: 'An error occurred while renaming the file.',
        });
    }
}






