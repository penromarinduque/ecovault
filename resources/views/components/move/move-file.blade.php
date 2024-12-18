<!-- It is never too late to be what you might have been. - George Eliot -->
<div id="move-file-div" class="">
    <div id="child-move-file-div">
        <!-- Heading for Edit File -->
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-700">Move <span id="label-file-name"> </span></h2>
            {{-- add summary --}}
            <button type="button" id="close-upload-btn" aria-controls="section-close-all"
                class="close-all-btn toggle-btn hover:bg-red-200 p-3 rounded-full text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <form id="move-form">
            @csrf
            <div class="mx-20 grid gap-6 grid-cols-3 items-center">
                <!-- Origin Section -->
                <div>
                    <h1 class="text-center sm:text-left">Origin</h1>
                    <div class="">
                        <input type="hidden" id="move-file-id">


                        @if ($type)
                            <label for="current_municipality-preview"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                Municipality</label>
                            <p disabled id="current_municipality-preview"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            </p>
                            <div class="mt-2">
                                <label for="current_permit_type-preview"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                    Category Type</label>
                                <p id="current_permit_type-preview" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                </p>
                            </div>
                        @elseif($record)
                            <div class="mt-2">
                                <label for="current_report_type-preview"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                    Permit Type</label>
                                <select id="current_report_type-preview" disabled
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                </select>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Center 'To' Text -->
                <div class="flex justify-center items-center">
                    <i class='bx  bx-md bx-right-arrow-alt '></i>
                </div>

                <!-- Destination Section -->
                <div>

                    @if ($type)
                        <h1 class="text-center sm:text-left">Destination</h1>
                        <div class="mt-2">
                            <label for="move_to_municipality"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Move to
                                municipality</label>
                            <select id="move_to_municipality" name="move_to_municipality"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            </select>

                        </div>
                    @elseif($record)
                        <h1 class="text-center sm:text-left">Destination</h1>
                        <div class="mt-2">
                            <label for="move_to_report-type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Move to
                                Report Type</label>
                            <select id="move_to_report-type" name="move_to_report_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            </select>

                        </div>
                    @endif
                    <div class="mt-2">
                        <label for="move_to_folder" "
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Move to
                            Folder</label>
                        <select id="move_to_folder" name="move_to_folder" dis
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </select>

                    </div>

                    <!-- Permit Type Field -->

                </div>
            </div>



            <div class="w-full text-end mt-4">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save
                    changes</button>
            </div>
        </form>
    </div>
</div>


<script>
    async function fetchFileDataMove(fileId) {
        let includePermit = {!! json_encode($includePermit ?? false) !!};


        // Fetch munic  ipalities from the API
        const fetchMunicipalities = async () => {
            const response = await fetch('https://psgc.gitlab.io/api/provinces/174000000/municipalities/');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        };

        // Fetch file data
        const url = `/api/files/${fileId}?includePermit=${includePermit}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error("Failed to fetch the file and permit data");

        const fileData = await response.json();
        if (!fileData.success) {
            console.error('API Error:', fileData.message);
            return;
        }

        // Extract necessary file data
        const {
            file
        } = fileData;
        const currentMunicipality = file.municipality;
        const permitType = file.permit_type;
        const reportType = file.report_type;
        // Set current municipality and permit type in their respective selects
        const currentMunicipalitySelect = document.getElementById("current_municipality-preview");
        const currentPermitTypeSelect = document.getElementById("current_permit_type-preview");
        const currentReportTypeSelect = document.getElementById("current_report_type-preview");
        const moveToReportType = document.getElementById("move-move_to_report_type");
        const moveToMunicipality = document.getElementById("move_to_municipality");
        // Format the permit type (capitalize and replace hyphens with spaces)


        document.getElementById("label-file-name").innerText = `"${file.file_name}"`;
        document.getElementById("move-file-id").value = file.id;

        if (file.permit_type) {
            const selectElement = document.getElementById("move_to_municipality");

            // Populate the "move_to_report_type" dropdown, excluding the current municipality
            try {
                const municipalities = await fetchMunicipalities();

                // Clear the "move_to_report_type" dropdown
                selectElement.innerHTML = `<option value="" disabled selected>Select a Municipality</option>`;

                // Add all municipalities except the current one
                municipalities.forEach(municipality => {
                    if (municipality.name.toLowerCase() !== currentMunicipality.toLowerCase()) {
                        const option = document.createElement("option");
                        option.value = municipality.name;
                        option.textContent = municipality.name;
                        selectElement.appendChild(option);
                    }
                });
            } catch (error) {
                console.error("Error fetching municipalities:", error);
                selectElement.innerHTML = `<option value="" disabled>Error loading data</option>`;
            }
            const formattedPermitType = permitType
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
            currentMunicipalitySelect.innerHTML =
                `<option value="${currentMunicipality}" selected>${currentMunicipality}</option>`;

            currentPermitTypeSelect.innerHTML =
                `<option value="${permitType}" selected>${formattedPermitType}</option>`;


        }

        if (file.report_type) {
            const selectElement = document.getElementById("move_to_report-type");
            const reportTypes = await fetchFileTypes(2);
            const formattedReportType = reportType
                .split('-')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
            reportTypes.forEach(fileType => {
                if (fileType.type_name.toLowerCase() !== reportType.toLowerCase()) {
                    const option = document.createElement("option");
                    option.value = fileType.type_name.toLowerCase();

                    let formattedText = fileType.type_name
                        .replace(/-/g, ' ') // Replace hyphens with spaces
                        .replace(/\b\w/g, function(match) {
                            return match.toUpperCase();
                        }); // Capitalize first letter of each word

                    option.textContent = formattedText;
                    selectElement.appendChild(option);
                }
            });
            currentReportTypeSelect.innerHTML =
                `<option value="${permitType}" selected>${file.report_type}</option>`;

        }
    }

    document.getElementById('move-form').addEventListener('submit', async function(event) {
        event.preventDefault();
        const csrfToken = "{{ csrf_token() }}";
        const formData = new FormData(this);

        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        const fileId = document.getElementById("move-file-id").value
        const res = await fetch(`/api/files/move/${fileId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        if (!res.ok) {
            console.log("Not working");
        }

        this.reset();
        refreshTable();
        showToast({
            type: 'success',
            message: 'File moved successfully.',

        });
    });


    async function fetchFileTypes(classification) {
        try {
            const response = await fetch(`/api/file-types?classification=${classification}`);

            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }

            const data = await response.json();

            if (data.success) {
                console.log('File types:', data.file_types);
                // Optionally, you can handle the file types and display them in your app
                return data.file_types;
            } else {
                console.log('Failed to retrieve file types');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Call the function with classification 2
</script>
