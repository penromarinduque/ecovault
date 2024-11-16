//love what you are doing

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
            fetchData()
            
            showSuccessAlert(result.message || "Operation completed successfully!");
        } else {
            showErrorAlert(result.message || 'Unknown error');
        }
    } catch (error) {
        showErrorAlert(error.message || 'An unexpected error occurred');
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
        // const fileId = event.target.dataset.fileId;
        // fetchFileData(fileId);
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
        //fetchFileData(fileId);
        fetchFileDetails(fileId);
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









