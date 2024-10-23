<div id="file-summary-div" class="p-4">
    <h2 class="text-lg font-bold mb-4">File Summary</h2>

    @if ($type == 'tree-cutting-permits')
        <!-- File Name -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Name of Client -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Number of Trees -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Number of Trees:</span>
                <span id="summary-number-of-trees" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Tree Species -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Tree Species:</span>
                <span id="summary-tree-species" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Location -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Location:</span>
                <span id="summary-location" class="text-gray-900"></span>
            </div>
        </div>

        <!-- Date Applied -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Date Applied:</span>
                <span id="summary-date-applied" class="text-gray-900"></span>
            </div>
        </div>
    @elseif ($type == 'chainsaw-registration')
        <!-- File Name -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Name of Client -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Location -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Location:</span>
                <span id="summary-location" class="text-gray-900"></span>
            </div>
        </div>

        <!-- Serial Number -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Serial Number:</span>
                <span id="summary-serial-number" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Date Applied -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Date Applied:</span>
                <span id="summary-date-applied" class="text-gray-900"></span>
            </div>
        </div>
    @elseif ($type == 'tree-plantation')
        <!-- File Name -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Name of Client -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Number of Trees -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Number of Trees:</span>
                <span id="summary-number-of-trees" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Location -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Location:</span>
                <span id="summary-location" class="text-gray-900"></span>
            </div>
        </div>

        <!-- Date Applied -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Date Applied:</span>
                <span id="summary-date-applied" class="text-gray-900"></span>
            </div>
        </div>
    @elseif ($type == 'tree-transport-permits')
        <!-- File Name -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Name of Client -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Number of Trees -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Number of Trees:</span>
                <span id="summary-number-of-trees" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Species -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Species:</span>
                <span id="summary-species" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Destination -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Destination:</span>
                <span id="summary-destination" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Date Applied -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Date Applied:</span>
                <span id="summary-date-applied" class="text-gray-900"></span>
            </div>
        </div>
    @elseif ($type == 'land-titles')
        <!-- File Name -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Name of Client -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Location -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Location:</span>
                <span id="summary-location" class="text-gray-900"></span>
            </div>
        </div>

        <!-- Lot Number -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Lot Number:</span>
                <span id="summary-lot-number" class="text-gray-900">Loading...</span>
            </div>
        </div>

        <!-- Property Category -->
        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Property Category:</span>
                <span id="summary-property-category" class="text-gray-900">Loading...</span>
            </div>
        </div>
    @endif


</div>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.body.addEventListener('click', (event) => {
            if (event.target.matches('.file-summary-button')) {
                const fileId = event.target.dataset.fileId;
                console.log('File Summary button clicked for file ID:', fileId);
                toggleVisibility(true); // Show summary, hide others
                fetchFileDetails(fileId);
            }
        });
    });

    // Function to toggle visibility of file summary and other divs
    function toggleVisibility(showSummary) {
        document.getElementById('file-summary-div').classList.toggle('hidden', !showSummary);
        document.getElementById('edit-file-div').classList.toggle('hidden', showSummary);
        document.getElementById('upload-file-div').classList.toggle('hidden', showSummary);
    }

    // Function to fetch file details from API
    function fetchFileDetails(fileId) {
        fetch(`/api/file/${fileId}`)
            .then(response => response.json())
            .then(data => handleFetchResponse(data))
            .catch(error => console.error('Error fetching file details:', error));
    }

    // Function to handle the API response and update the UI
    function handleFetchResponse(data) {
        if (data.success) {
            console.log(data); // Debugging data output
            updateFileSummary(data);
        } else {
            alert(data.message);
        }
    }

    // Function to update the file summary UI with fetched data
    function updateFileSummary(data) {
        // Clear previous values
        clearSummaryFields();

        const permitType = data.permit.type; // Assuming the permit type is included in the response
        console.log('try', permitType);
        switch (permitType) {
            case 'tree-cutting-permits':
                document.getElementById('summary-file-name').textContent = data.file.file_name;
                document.getElementById('summary-client-name').textContent = data.permit.name_of_client;
                document.getElementById('summary-number-of-trees').textContent = data.permit.number_of_trees;
                document.getElementById('summary-tree-species').textContent = data.permit.tree_species;
                document.getElementById('summary-location').textContent = data.permit.location;
                document.getElementById('summary-date-applied').textContent = data.permit.date_applied;
                break;

            case 'chainsaw-registration':
                document.getElementById('summary-file-name').textContent = data.file.file_name;
                document.getElementById('summary-client-name').textContent = data.permit.name_of_client;
                document.getElementById('summary-location').textContent = data.permit.location;
                document.getElementById('summary-serial-number').textContent = data.permit.serial_number;
                document.getElementById('summary-date-applied').textContent = data.permit.date_applied;
                break;

            case 'tree-plantation':
                document.getElementById('summary-file-name').textContent = data.file.file_name;
                document.getElementById('summary-client-name').textContent = data.permit.name_of_client;
                document.getElementById('summary-number-of-trees').textContent = data.permit.number_of_trees;
                document.getElementById('summary-location').textContent = data.permit.location;
                document.getElementById('summary-date-applied').textContent = data.permit.date_applied;
                break;

            case 'tree-transport-permits':
                document.getElementById('summary-file-name').textContent = data.file.file_name;
                document.getElementById('summary-client-name').textContent = data.permit.name_of_client;
                document.getElementById('summary-number-of-trees').textContent = data.permit.number_of_trees;
                document.getElementById('summary-species').textContent = data.permit.species;
                document.getElementById('summary-destination').textContent = data.permit.destination;
                document.getElementById('summary-date-applied').textContent = data.permit.date_applied;
                break;

            case 'land-titles':
                document.getElementById('summary-file-name').textContent = data.file.file_name;
                document.getElementById('summary-client-name').textContent = data.permit.name_of_client;
                document.getElementById('summary-location').textContent = data.permit.location;
                document.getElementById('summary-lot-number').textContent = data.permit.lot_number;
                document.getElementById('summary-property-category').textContent = data.permit.property_category;
                break;

            default:
                console.warn('Unknown permit type:', permitType);
                break;
        }
    }

    // Function to clear previous values in the summary fields
    function clearSummaryFields() {
        const fields = [
            'summary-file-name',
            'summary-client-name',
            'summary-number-of-trees',
            'summary-tree-species',
            'summary-location',
            'summary-date-applied',
            'summary-serial-number',
            'summary-species',
            'summary-destination',
            'summary-lot-number',
            'summary-property-category'
        ];

        fields.forEach(field => {
            document.getElementById(field).textContent = ''; // Clear each field
        });
    }
</script>
