async function openFileModal(id) {
    try {
        // First API call to get file metadata
        const response = await fetch(`/api/files/${fileId}?includePermit=false`);
        const data = await response.json();

        if (response.ok) {
            setFileName(data.file);  // Set file name as needed
        } else {
            console.error('Error in first API response:', data.message);
            return; // Stop further execution if the first call fails
        }
    } catch (error) {
        console.error('Error fetching the file in first API call:', error);
        return; // Stop further execution if there's an error
    }

    try {
        // Second API call to get the converted PDF file
        const res = await fetch(`/api/files/view/${id}`);

        // Check content type returned by the server
        const contentType = res.headers.get("content-type");
        console.log('Content-Type:', contentType); // Log the content type for debugging

        if (contentType.includes('application/json')) {
                // Assuming that if it's JSON, it's a doc/docx file with a viewUrl
                const fileData = await res.json();

                if (fileData.viewUrl) {
                    // Microsoft Office Online Viewer URL for .doc/.docx files
                    const fileFrame = document.getElementById('fileFrame');
                    fileFrame.src = fileData.viewUrl;  // Set the iframe src to the Microsoft viewer URL
                    document.getElementById('fileModal').classList.remove('hidden');  // Show the modal
                } else {
                    console.error('No viewUrl found in the response:', fileData);
                }
            } else if (contentType.includes('application/pdf')) {
                // Handle PDF as a blob
                const blob = await res.blob();
                const fileUrl = URL.createObjectURL(blob);  // Create a URL for the blob
                
                // Load the PDF into the iframe
                const fileFrame = document.getElementById('fileFrame');
                fileFrame.src = fileUrl;  // Set the iframe src to the blob URL
                document.getElementById('fileModal').classList.remove('hidden');  // Show the modal
            }  else {
            console.error('Error fetching PDF:', res.status, await res.text());
        }
    } catch (error) {
        console.error('Error fetching the file in second API call:', error);
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

