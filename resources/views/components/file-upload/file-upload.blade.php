<!-- Life is available only in the present moment. - Thich Nhat Hanh -->
<div id="upload-file-div" class="items-center justify-center mx-10">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold text-gray-700">Upload File</h2> {{-- add summary --}}
        <button type="button" id="close-upload-btn"
            class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <i class='bx bx-x bx-md'></i>
        </button>
    </div>
    <form id="upload-form" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-x-10">
            <div class="col-span-2 ">
                <div class="flex items-center space-x-4">
                    <label for="file-upload" class="block mt-2">
                        <input type="file" name="file" class="hidden" id="file-upload">
                        <span
                            class="inline-block bg-green-500 text-white rounded-md px-8 py-2 cursor-pointer hover:bg-green-800 transition duration-200">
                            <i class='bx bx-cloud-upload'></i> Choose File
                        </span>
                    </label>

                    <p id="file-upload-name" class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                        No file chosen
                    </p>

                </div>

                <p id="file-upload-error" class="text-red-500  min-h-[1.5rem] invisible mt-2 ml-32">
                    Please choose a file to upload.</p>
            </div>
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
                    class="w-36 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
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
    const fileInput = document.getElementById('file-upload');
    const fileUploadName = document.getElementById('file-upload-name');
    const fileUploadError = document.getElementById('file-upload-error');


    function validateFile() {
        const file = fileInput.files[0];


        if (fileInput.files.length === 0) {
            fileUploadError.textContent = "Please upload a file.";
            fileUploadError.classList.remove('invisible');
            return false;
        }
        const allowedTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/png',
            'application/zip',
            'application/x-zip-compressed', // Some browsers may use this
            'multipart/x-zip' // Occasionally used
        ];
        if (!allowedTypes.includes(file.type)) {
            fileUploadError.textContent = "Invalid file type. Please upload a PDF, image, or validateFileZIP file.";
            fileUploadError.classList.remove('invisible');
            return false;
        }
        fileUploadError.classList.add('invisible');
        return true;
    }

    fileInput.addEventListener('change', function() {
        const fileUploadError = document.getElementById('file-upload-error');

        if (fileInput.files.length > 0) {
            const selectedFile = fileInput.files[0];
            fileUploadName.textContent = selectedFile.name; // Update Step 1
            fileUploadError.classList.add('invisible'); // Hide error if file is chosen
        } else {
            fileUploadName.textContent = 'No file chosen'; // Reset if no file is chosen
            fileUploadError.classList.remove('invisible'); // Show error if no file is chosen
        }
    });



    let fileId;

    document.getElementById('upload-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const csrfToken = "{{ csrf_token() }}";
        const uploadButton = document.getElementById('upload-btn');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');

        buttonText.classList.add('hidden');
        buttonSpinner.classList.remove('hidden');
        let report = {!! json_encode($record ?? '') !!};
        let isAdmin = {!! json_encode($isAdmin) !!};
        let type = {!! json_encode($type) !!};
        let municipality = {!! json_encode($municipality) !!};
        let category = {!! json_encode($category ?? '') !!};
        let isArchived = {!! json_encode($isArchived) !!};

        const params = {
            type: type,
            municipality: municipality,
            report: report || '',
            category: category || '',
            isArchived: isArchived
        };

        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );
        // console.log("Params Before Filtering:", params);
        // Build the query string
        const queryParams = new URLSearchParams(filteredParams).toString();

        //console.log('this', queryParams);
        const formData = new FormData(this);

        try {
            // File upload
            const fileUploadResponse = await fetch(`/file-upload?${queryParams}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!fileUploadResponse.ok) throw new Error("File upload failed");

            const fileResponseData = await fileUploadResponse.json();
            const fileId = fileResponseData.fileId; // Ensure `fileId` is in the response
            refreshTable();
            // Check if permit data exists before proceeding
            if (type !== undefined && type !== null && type !== '') {
                const permitData = new FormData(this);
                permitData.append('file_id', fileId);
                console.log(fileId);
                const permitUploadResponse = await fetch(`/permit-upload?${queryParams}`, {
                    method: 'POST',
                    body: permitData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!permitUploadResponse.ok) throw new Error("Permit upload failed");

                refreshTable();
            }
            showToast("File uploaded successfully", 'top-right', 'success')

            buttonText.classList.remove('hidden');
            buttonSpinner.classList.add('hidden');
            document.getElementById('file-upload-name').textContent = 'No file chosen';

            this.reset();
        } catch (error) {
            showToast(error.message, 'top-right', 'danger')
        }
    });
</script>
