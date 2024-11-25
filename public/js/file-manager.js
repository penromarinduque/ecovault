//love what you are doing


//Refresh Table In every activity upload/edit/archiving/etc
function refreshTable(){
    fetchData();
    fetchDatas();
}
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
            
            showToast(result.message, 'top-right', 'success');
        } else {
            showToast(result.message, 'top-right', 'success');
        }
    } catch (error) {
        showToast(error.message, 'top-right', 'danger');
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
    const sections = ['upload-file-div', 'edit-file-div', 'file-summary-div', 'move-file-div'];
    sections.forEach(section => {
        const sectionDiv = document.getElementById(section);
        sectionDiv.classList.toggle('hidden', section !== showDivId);
    });
}

// Event listeners for buttons

document.body.addEventListener('click', (event) => {
    if (event.target.matches('.move-file-div')) {
        toggleSections(true);
        
         const fileId = event.target.dataset.fileId;
        // fetchFileData(fileId);
         fetchFileDataMove(fileId)
         toggleDivVisibility('move-file-div');
    }
});

document.getElementById('uploadBtn').addEventListener('click', () => {
    toggleSections(true);
    toggleDivVisibility('upload-file-div');
});
document.body.addEventListener('click', (event) => {
    if (event.target.matches('.edit-button')) {
        toggleSections(true);
        const fileId = event.target.dataset.fileId;
        fetchFileData(fileId);
        
        // fetchFileDetails(fileId);
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

document.addEventListener('DOMContentLoaded', () => {
    const closeEditBtn = document.getElementById('close-edit-btn');
    if (closeEditBtn) {
        closeEditBtn.addEventListener('click', () => toggleSections(false));
    }
});
document.addEventListener('DOMContentLoaded', () => {
    
    document.getElementById('close-upload-btn').addEventListener('click', () => toggleSections(false));
    document.getElementById('close-summary-btn').addEventListener('click', () => toggleSections(false));
    document.getElementById('close-edit-button').addEventListener('click', () => toggleSections(false));
});









