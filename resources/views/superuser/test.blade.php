@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')


@section('content')
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <table id="request-access-table" class="min-w-full bg-white border border-gray-300">
        <!-- Table content will be populated dynamically -->
    </table>

    <script>
        // Declare dataTable variable globally
        let dataTable;

        document.addEventListener("DOMContentLoaded", function() {
            // Define parameters for the request
            fetchRequestAccess();
        });
        async function fetchRequestAccess() {
            try {
                const response = await fetch('/api/files/GET/request-access');
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Fetch failed with status: ${response.status} - ${errorText}`);
                }

                const data = await response.json();
                initializeTable(data);
            } catch (error) {
                console.error('Fetch operation error:', error.message || error);
            }
        }


        function initializeTable(data) {
            if (dataTable) {
                dataTable.destroy();
            }

            const customData = formData(data.requests); // Changed to use 'data.requests'
            console.log(customData);
            const dataTableElement = document.getElementById("request-access-table");

            if (dataTableElement && typeof simpleDatatables.DataTable !== 'undefined') {
                dataTable = new simpleDatatables.DataTable(dataTableElement, {
                    classes: {
                        active: "datatable-active bg-red-400",
                        loading: "datatable-loading text-sm",
                        headercontainer: "datatable-headercontainer bg-gray-500 m-10",
                        container: "datatable-container p-10 bg-blue-500",
                        dropdown: "datatable-perPage flex items-center",
                        selector: "per-page-selector px-2 py-1 border rounded border-gray-300 text-gray-600",
                        ellipsis: "datatable-ellipsis text-lg",
                        info: "datatable-info text-sm text-gray-500",
                        search: "datatable-search",
                        input: "datatable-input",
                        top: "datatable-top",
                        table: "datatable-table",
                        bottom: "datatable-bottom",
                        wrapper: "datatable-wrapper bg-red-500 p-10"
                    },
                    data: customData,
                    paging: true,
                    nextPrev: true, // Enable previous and next buttons
                    pagerDelta: -6, // Show only one page number on each side of the current page
                    perPageSelect: [5, 10, 20, 50],
                    perPage: 5,
                    sortable: true,
                    searchable: true,
                    ellipsisText: '...',
                    labels: {
                        perPage: "<span class='text-gray-500 m-3'>Rows</span>",
                        searchTitle: "Search through table data",
                        placeholder: "Search...",
                    },
                });

                tableEvents(data); // Custom function for handling events if required
            }
        }

        function tableEvents(data) {
            const events = ["init", "refresh", "page", "perpage", "update"];
            events.forEach(event => {
                dataTable.on(`datatable.${event}`, () => {
                    initializeDropdowns(data);
                });
            });
        }

        function formData(requests) {
            function formatDate(dateString) {
                const options = {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                };
                return new Intl.DateTimeFormat('en-GB', options).format(new Date(dateString));
            }

            return {
                headings: ["Name", "File Name", "Date Requested", "Handled By", "Status", "Actions"],
                data: requests.map(request => ({
                    cells: [
                        request.requested_by.name,
                        request.file.file_name, // You can customize this to show a file name if needed
                        formatDate(request.created_at), // Format date as needed
                        request.handled_by ? request.handled_by.name : 'Unknown', // Display admin's name
                        request.status.charAt(0).toUpperCase() + request.status.slice(
                            1), // Capitalize status
                        generateKebab(request.file_id), // Placeholder for action buttons
                    ],
                    attributes: {
                        class: "text-gray-700 text-left font-semibold hover:bg-gray-100 capitalize"
                    },
                }))
            };
        }
        // Generate action buttons for dropdowns
        function generateKebab(fileId) {
            return `
        <button 
            class="bg-green-500 text-white px-2 py-1 rounded" 
            onclick="updateRequestStatus(${fileId}, 'approved')">
            Approve
        </button>
        <button 
            class="bg-red-500 text-white px-2 py-1 rounded" 
            onclick="updateRequestStatus(${fileId}, 'rejected')">
            Reject
        </button>
    `;
        }

        // Create dropdown for each file
        function createDropdown(fileId) {
            const dropdownButton = document.getElementById(`dropdownLeftButton${fileId}`);
            const dropdownElement = document.getElementById(`dropdownLeft${fileId}`);
            if (dropdownButton && dropdownElement) {
                new Dropdown(dropdownElement, dropdownButton, {
                    placement: 'left',
                    triggerType: 'click',
                    offsetSkidding: 0,
                    offsetDistance: 0,
                    ignoreClickOutsideClass: false,
                });
            }
        }

        function initializeDropdowns(data) {
            data.requests.forEach((file) => {
                createDropdown(file.id);
            });
        }



        async function updateRequestStatus(requestId, status) {
            try {
                const csrfToken = "{{ csrf_token() }}";
                const response = await fetch(`/api/files/request-access/${requestId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        status
                    }),
                });

                const {
                    success,
                    message
                } = await response.json();

                if (success) {
                    alert('Request status updated successfully!');
                } else {
                    console.error(message);
                }
            } catch (error) {
                console.error('Error updating request status:', error);
            }
        }
    </script>









    <!-- Parent container is hidden initially -->

    {{-- 
    <h1>Select Location</h1>

    <!-- Province Dropdown -->
    <label for="province">Province:</label>
    <select id="province">
        <option value="">Loading Provinces...</option>
    </select>

    <!-- Municipality Dropdown -->
    <label for="municipality">Municipality:</label>
    <select id="municipality" disabled>
        <option value="">Select a Province first</option>
    </select>

    <!-- Barangay Dropdown -->
    <label for="barangay">Barangay:</label>
    <select id="barangay" disabled>
        <option value="">Select a Municipality first</option>
    </select>

    <script>
        const provinceDropdown = document.getElementById('province');
        const municipalityDropdown = document.getElementById('municipality');
        const barangayDropdown = document.getElementById('barangay');

        // Load Provinces
        async function loadProvinces() {
            try {
                const response = await fetch('https://psgc.gitlab.io/api/provinces/');
                if (!response.ok) throw new Error('Failed to fetch provinces.');

                const provinces = await response.json();
                provinceDropdown.innerHTML = "<option value=''>Select Province</option>";

                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    provinceDropdown.appendChild(option);
                });
            } catch (error) {
                console.error(error);
                provinceDropdown.innerHTML = "<option value=''>Error Loading Provinces</option>";
            }
        }

        // Load Municipalities based on selected Province
        async function loadMunicipalities(provinceCode) {
            try {
                const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/municipalities/`);
                if (!response.ok) throw new Error('Failed to fetch municipalities.');

                const municipalities = await response.json();
                municipalityDropdown.innerHTML = "<option value=''>Select Municipality</option>";

                municipalities.forEach(municipality => {
                    const option = document.createElement('option');
                    option.value = municipality.code;
                    option.textContent = municipality.name;
                    municipalityDropdown.appendChild(option);
                });

                municipalityDropdown.disabled = false;
                barangayDropdown.innerHTML = "<option value=''>Select a Municipality first</option>";
                barangayDropdown.disabled = true;
            } catch (error) {
                console.error(error);
                municipalityDropdown.innerHTML = "<option value=''>Error Loading Municipalities</option>";
                municipalityDropdown.disabled = true;
            }
        }

        // Load Barangays based on selected Municipality
        async function loadBarangays(municipalityCode) {
            try {
                const response = await fetch(
                    `https://psgc.gitlab.io/api/municipalities/${municipalityCode}/barangays/`);
                if (!response.ok) throw new Error('Failed to fetch barangays.');

                const barangays = await response.json();
                barangayDropdown.innerHTML = "<option value=''>Select Barangay</option>";

                barangays.forEach(barangay => {
                    const option = document.createElement('option');
                    option.value = barangay.code;
                    option.textContent = barangay.name;
                    barangayDropdown.appendChild(option);
                });

                barangayDropdown.disabled = false;
            } catch (error) {
                console.error(error);
                barangayDropdown.innerHTML = "<option value=''>Error Loading Barangays</option>";
                barangayDropdown.disabled = true;
            }
        }

        // Event Listeners
        provinceDropdown.addEventListener('change', () => {
            const provinceCode = provinceDropdown.value;
            if (provinceCode) {
                loadMunicipalities(provinceCode);
            } else {
                municipalityDropdown.innerHTML = "<option value=''>Select a Province first</option>";
                municipalityDropdown.disabled = true;
                barangayDropdown.innerHTML = "<option value=''>Select a Municipality first</option>";
                barangayDropdown.disabled = true;
            }
        });

        municipalityDropdown.addEventListener('change', () => {
            const municipalityCode = municipalityDropdown.value;
            if (municipalityCode) {
                loadBarangays(municipalityCode);
            } else {
                barangayDropdown.innerHTML = "<option value=''>Select a Municipality first</option>";
                barangayDropdown.disabled = true;
            }
        });

        // Initialize Provinces on Page Load
        loadProvinces();
    </script> --}}
@endsection
