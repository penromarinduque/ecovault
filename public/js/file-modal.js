
async function openFileModal(fileUrl, id) {
    const response = await fetch(`/api/file-only/${id}`);
    const data = await response.json();

    if (response.ok) {
        const file = data.file;
        
        setFileName(file);
        
        // Get file extension
        
        console.log(data.file.file_path)
        // Check for .doc or .docx files
        // if (data.type === 'google-viewer') {
        //         const viewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(file)}&embedded=true`;
        //         window.open(viewerUrl, '_blank'); // Open in a new tab
        
        // }//// problem for viewer docx
        //  else {
        //     // For other files (like PDF), display them in the iframe
        //     document.getElementById('fileModal').classList.remove('hidden'); // Show modal
        //     //document.getElementById('fileFrame').src = fileUrl; // Load file into iframe
        // }
    } else {
        console.error('Error:', data.message); // Handle the error accordingly
    }
}


// Function to close modal and remove blur
function closeFileModal() {
    document.getElementById('fileModal').classList.add('hidden'); // Hide modal
    document.getElementById('fileFrame').src = ''; // Clear iframe
    
}

// Function to print the file from iframe
// function printFile() {
//     let iframe = document.getElementById('fileFrame');
//     iframe.contentWindow.focus(); // Focus on iframe
//     iframe.contentWindow.print(); // Trigger print function in iframe
// }

function setFileName(file) {
    const maxLength = 25; // Adjust this to your desired maximum length
    const fileName = file.file_name; // Example: "example_filename.txt"
    
    // Split the file name into name and extension
    const lastDotIndex = fileName.lastIndexOf(".");
    
    // Extract the name and extension
    const name = lastDotIndex !== -1 ? fileName.substring(0, lastDotIndex) : fileName;
    const extension = lastDotIndex !== -1 ? fileName.substring(lastDotIndex) : "";

    // Limit the name length
    const truncatedName = name.length > maxLength ? name.substring(0, maxLength) + "..." : name;

    // Set the text content to the truncated name plus the extension
    document.getElementById("file-name").textContent = truncatedName + extension;
}

