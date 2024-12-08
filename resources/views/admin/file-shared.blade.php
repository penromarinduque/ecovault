@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <x-modal.file-modal />
    <div class="overflow-auto rounded-md text-black p-4">
        <div id="shared-files-container" class="bg-gray-100 p-4 rounded-lg shadow">
            <p class="text-center text-gray-600">Loading shared files...</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const container = document.getElementById('shared-files-container');
            const authId = {!! json_encode(auth()->id()) !!};

            try {
                const response = await fetch(`/api/sharewithme?user_id=${authId}`);
                const result = await response.json();

                if (!result.success) {
                    container.innerHTML =
                        `<p class="text-center text-red-500">${result.message || 'Failed to load shared files.'}</p>`;
                    return;
                }

                const sharedFiles = result.sharewithme;

                if (sharedFiles.length === 0) {
                    container.innerHTML = '<p class="text-center text-gray-600">No files shared with you.</p>';
                    return;
                }

                container.innerHTML = `
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-200 text-left">
                        <tr>
                            <th class="p-3 border">File Name</th>
                            <th class="p-3 border">Shared By</th>
                            <th class="p-3 border">Permit Type</th>
                            <th class="p-3 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${sharedFiles.map(file => `
                                                                                                                                                <tr class="bg-white border-b hover:bg-gray-50">
                                                                                                                                                    <td class="p-3 border">${file.file_name}</td>
                                                                                                                                                    <td class="p-3 border">${file.shared_by_name}</td>
                                                                                                                                                    <td class="p-3 border">${file.permit_type || file.report_type}</td>
                                                                                                                                                    <td class="p-3 border flex gap-4">
                                                                                                                                                         <a 
                                                                                class="items-center gap-2 px-4 py-2 cursor-pointer hover:bg-blue-100 inline-flex rounded-md border border-blue-200 text-blue-600 text-sm"
                                                                              onclick="openFileModal(${file.file_id})">
                                                                                <span>View</span>
                                                                            </a>
                                                                            <!-- Download Button -->
                                                                            <a 
                                                                               href="/api/files/download/${file.file_id}" 
                                                                                target="_blank"
                                                                                class="flex items-center px-4 py-2 hover:bg-green-100 rounded-md border border-green-200 text-green-600 text-sm"
                                                                            >
                                                                                <span>Download</span>
                                                                            </a>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            `).join('')}
                    </tbody>
                </table>
            `;
            } catch (error) {
                console.error('Error fetching shared files:', error);
                container.innerHTML = `<p class="text-center text-red-500">Error loading shared files.</p>`;
            }
        });






        async function openFileModal(id) {
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
                const compatibleTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp',
                    'image/webp', 'image/tiff'
                ];

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
    </script>

@endsection
