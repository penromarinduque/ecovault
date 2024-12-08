async function openFileModal(id) {
    console.log("im running")
    try {
        // First API call to get file metadata
        const response = await fetch(`/api/files/${id}?includePermit=false`);
        const data = await response.json();

        if (response.ok) {
            setFileName(data.file); // Set file name as needed
        } else {
            console.error('Error in first API response:', data.message);
            return; // Stop further execution if the first call fails
        }
    } catch (error) {
        console.error('Error fetching the file metadata in the first API call:', error);
        return; // Stop further execution if there's an error
    }

    try {
        // Second API call to get the file content based on the file ID
        const res = await fetch(`/api/files/view/${id}`, {
            headers: {
                'Accept': '*/*' // Ensure the server knows it can send any content type
            }
        });

        // Check content type returned by the server
        const contentType = res.headers.get("content-type");
        console.log('Content-Type:', contentType); // Log the content type for debugging

        if (!res.ok) {
            console.error('Error in second API response:', res.status, await res.text());
            return;
        }

        // Check if the content type is compatible for iframe display
        const compatibleTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/tiff'];

        if (compatibleTypes.includes(contentType)) {
            const fileUrl = `/api/files/view/${id}`;
            document.getElementById('fileModal').classList.remove('hidden');
            document.getElementById('fileFrame').src = fileUrl; 
        } else {
            // If it's a ZIP file, open it for download
            window.location.href = `/api/files/view/${id}`; // Redirect to download ZIP file
        }

    
    } catch (error) {
        console.error('Error fetching the file in the second API call:', error);
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

