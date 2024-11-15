<!-- An unexamined life is not worth living. - Socrates -->
<div id="edit-file-div" class="items-center justify-center mx-10">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold text-gray-700">Edit File</h2> {{-- add summary --}}
        <button type="button" id="close-edit-btn"
            class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <i class='bx bx-x bx-md'></i>
        </button>
    </div>
    <form id="edit-file-form" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-x-10">
            {{-- <div class="col-span-2 ">
                <div class="flex items-center space-x-4">
                    <label for="file-upload" class="block mt-2">
                        <input type="file" name="file" class="hidden" id="file-upload">
                        <span
                            class="inline-block bg-green-500 text-white rounded-md px-8 py-2 cursor-pointer hover:bg-green-600 transition duration-200">
                            <i class='bx bx-cloud-upload'></i> Choose File
                        </span>
                    </label>

                    <p id="file-upload-name" class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                        No file chosen
                    </p>

                </div>

                <p id="file-upload-error" class="text-red-500  min-h-[1.5rem] invisible mt-2 ml-32">
                    Please choose a file to upload.</p>
            </div> --}}
            <!-- step 1 -->
            <div class="font-medium ">
                @if (!$record)
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client" placeholder="Enter Value"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid name for the client!
                        </p>
                    </div>
                @endif
                <div class="my-4">
                    <label for="office-source" class="block mb-2 text-sm font-medium text-gray-700">Office
                        Source</label>
                    <input type="text" id="office-source" name="office_source" placeholder="Enter office source"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                        autocomplete="off" required>
                    <p id="office-source-error" class="mt-2 text-sm text-red-600 hidden">
                        <span class="font-medium">Please!</span> Enter valid input!
                    </p>
                </div>

                <div class="my-4">
                    <label for="classification"
                        class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                    <select id="classification" name="classification"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                        autocomplete="off" required>
                        <option value="" disabled selected>Select a Classification</option>
                        <option value="highly-technical">Highly Technical</option>
                        <option value="simple">Simple</option>
                    </select>
                </div>
            </div>

            <!-- step 2 -->
            <div class="font-medium">
                @if ($type == 'tree-cutting-permits')
                    <div class="my-4">
                        <h2 class="block mb-2 text-sm font-medium text-gray-700">Add Tree
                            Specification</h2>
                        <button type="button" id="add-file-specification"
                            class="text-blue-700 mb-2 bg-blue-100 border border-blue-400 hover:bg-blue-200 focus:ring-2  focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2">
                            <svg class="size-5 text-red-700 font-extrabold" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Click to Add
                        </button>
                    </div>
                    <!-- Show species for tree-cutting-permits, tree-transport-permits -->

                    <!-- this for pop up modal for adding no. of trees/species/location/date applied/ -->
                @elseif ($type == 'chainsaw-registration')
                    <!-- Location Field -->
                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter location">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Serial Number Field -->
                    <div class="my-4">
                        <label for="serial_number" class="block mb-2 text-sm font-medium text-gray-700">Serial
                            Number</label>
                        <input type="text" id="serial_number" name="serial_number"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter serial number">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Date Applied Field -->
                    <div class="my-4">
                        <label for="date_applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date_applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>
                @elseif ($type == 'tree-plantation')
                    <!-- Number of Trees Field -->
                    <div class="my-4">
                        <label for="number_of_trees" class="block mb-2 text-sm font-medium text-gray-700">No.
                            of Trees</label>
                        <input type="number" id="number_of_trees" name="number_of_trees"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter number of trees">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Location Field -->
                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter location">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Date Applied Field -->
                    <div class="my-4">
                        <label for="date_applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date_applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>
                @elseif ($type == 'tree-transport-permits')
                    <!-- Transport Permits Inputs -->
                    <div class="my-4">
                        <h2 class="block mb-2 text-sm font-medium text-gray-700">Add Tree
                            Specification</h2>
                        <button type="button" id="add-file-specification"
                            class="text-blue-700 mb-2 bg-blue-100 border border-blue-400 hover:bg-blue-200 focus:ring-2  focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2">
                            <svg class="size-5 text-red-700 font-extrabold" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Click to Add
                        </button>
                    </div>
                @elseif ($type == 'land-titles')
                    <!-- Location Field -->
                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter location">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Lot Number Field -->
                    <div class="my-4">
                        <label for="lot_number" class="block mb-2 text-sm font-medium text-gray-700">Lot
                            Number</label>
                        <input type="text" id="lot_number" name="lot_number"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required placeholder="Enter lot number">
                        <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter
                            valid
                            input!</p>
                    </div>

                    <!-- Property Category Field -->
                @endif
            </div>
            @include('components.file-upload.specification-section')
            <div class="mt-4 flex justify-end gap-4 col-span-2">
                <button id="upload-btn" type="submit"
                    class="bg-green-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition duration-200">
                    <span id="button-spinner" class="hidden">
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor" />
                        </svg>
                        Loading...
                    </span>
                    <span id="button-text">Upload</span>
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    let selectedFileId;
    let permitType;
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // This script fetches file data when an edit button is clicked
    async function fetchFileData(fileId) {


        // Show loading screen
        // document.getElementById('loading').classList.remove('hidden');
        // document.getElementById('child-edit-file-div').classList.add('hidden');
        try {

            //await new Promise(resolve => setTimeout(resolve, 1000));
            const response = await fetch(`/api/files/${fileId}?includePermit=true`);
            const data = await response.json();

            if (data.success) {
                const file = data.file; // File data
                const permit = data.permit; // Permit details

                // Store the fileId and permit_type in global variables
                selectedFileId = fileId;
                permitType = file.permit_type;

                // Common fields for all permits
                document.getElementById('edit-office_source').value = file.office_source;
                document.getElementById('edit-classification').value = file.classification;
                // Check the permit type and populate fields accordingly
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('child-edit-file-div').classList.remove('hidden');
                switch (file.permit_type) {
                    case 'tree-cutting-permits':
                        document.getElementById('edit-client_name').value = permit.name_of_client;
                        document.getElementById('edit-number_of_trees').value = permit.number_of_trees;
                        document.getElementById('edit-location').value = permit.location;
                        document.getElementById('edit-date_applied').value = permit.date_applied;
                        document.getElementById('edit-species').value = permit.species;
                        break;
                    case 'chainsaw-registration':
                        document.getElementById('edit-client_name').value = permit.name_of_client;
                        document.getElementById('edit-location').value = permit.location;
                        document.getElementById('edit-serial_number').value = permit.serial_number;
                        document.getElementById('edit-date_applied').value = permit.date_applied;
                        break;
                    case 'tree-plantation':
                        document.getElementById('edit-client_name').value = permit.name_of_client;
                        document.getElementById('edit-number_of_trees').value = permit.number_of_trees;
                        document.getElementById('edit-location').value = permit.location;
                        document.getElementById('edit-date_applied').value = permit.date_applied;
                        break;
                    case 'tree-transport-permits':
                        document.getElementById('edit-client_name').value = permit.name_of_client;
                        document.getElementById('edit-number_of_trees').value = permit.number_of_trees;
                        document.getElementById('edit-destination').value = permit.destination;
                        document.getElementById('edit-date_applied').value = permit.date_applied;
                        document.getElementById('edit-date_of_transport').value = permit.date_of_transport;
                        document.getElementById('edit-species').value = permit.species;
                        break;
                    case 'land-titles':
                        document.getElementById('edit-client_name').value = permit.name_of_client;
                        document.getElementById('edit-location').value = permit.location;
                        document.getElementById('edit-lot_number').value = permit.lot_number;
                        document.getElementById('edit-property_category').value = permit.property_category;
                        break;
                    default:
                        console.error('Unknown permit type:', file.permit_type);
                }

            } else {
                console.error(data.message);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        } finally {
            // Hide loading screen after processing
            // document.getElementById('loading').classList.add('hidden');
        }
    }

    document.getElementById('edit-file-form').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent form from submitting normally
        const csrfToken = document.querySelector('input[name="_token"]').value;

        // Initialize FormData object to hold the form data
        const formData = new FormData();
        formData.append('office_source', document.getElementById('edit-office_source').value);
        formData.append('classification', document.getElementById('edit-classification').value);
        formData.append('permit_type', permitType); // Store the permit type

        // Populate permit fields based on the permit type
        switch (permitType) {
            case 'tree-cutting-permits':
                formData.append('permit[name_of_client]', document.getElementById('edit-client_name')
                    .value);
                formData.append('permit[number_of_trees]', document.getElementById('edit-number_of_trees')
                    .value);
                formData.append('permit[location]', document.getElementById('edit-location').value);
                formData.append('permit[date_applied]', document.getElementById('edit-date_applied').value);
                formData.append('permit[species]', document.getElementById('edit-species').value);
                break;
            case 'chainsaw-registration':
                formData.append('permit[name_of_client]', document.getElementById('edit-client_name')
                    .value);
                formData.append('permit[location]', document.getElementById('edit-location').value);
                formData.append('permit[serial_number]', document.getElementById('edit-serial_number')
                    .value);
                formData.append('permit[date_applied]', document.getElementById('edit-date_applied').value);
                break;
            case 'tree-plantation':
                formData.append('permit[name_of_client]', document.getElementById('edit-client_name')
                    .value);
                formData.append('permit[number_of_trees]', document.getElementById('edit-number_of_trees')
                    .value);
                formData.append('permit[location]', document.getElementById('edit-location').value);
                formData.append('permit[date_applied]', document.getElementById('edit-date_applied').value);
                break;
            case 'tree-transport-permits':
                formData.append('permit[name_of_client]', document.getElementById('edit-client_name')
                    .value);
                formData.append('permit[number_of_trees]', document.getElementById('edit-number_of_trees')
                    .value);
                formData.append('permit[destination]', document.getElementById('edit-destination').value);
                formData.append('permit[date_applied]', document.getElementById('edit-date_applied').value);
                formData.append('permit[date_of_transport]', document.getElementById(
                    'edit-date_of_transport').value);
                formData.append('permit[species]', document.getElementById('edit-species').value);
                break;
            case 'land-titles':
                formData.append('permit[name_of_client]', document.getElementById('edit-client_name')
                    .value);
                formData.append('permit[location]', document.getElementById('edit-location').value);
                formData.append('permit[lot_number]', document.getElementById('edit-lot_number').value);
                formData.append('permit[property_category]', document.getElementById(
                    'edit-property_category').value);
                break;
            default:

        }


        try {
            // Send formData as FormData in the request body
            const response = await fetch(`/api/files/update/${selectedFileId}?hasPermit=true`, {
                method: 'POST', // or 'PUT' depending on your API design
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            });

            const result = await response.json();

            if (result.success) {
                fetchData();
            } else {
                console.error(result.message);
                alert('Failed to update the file.');
            }
        } catch (error) {
            console.error('Error updating the file:', error);
        }
    });
</script>
