<!-- An unexamined life is not worth living. - Socrates -->
<div id="edit-file-div" class="items-center justify-center mx-10">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold text-gray-700">Edit File</h2> {{-- add summary --}}
        <button type="button" id="close-edit-button"
            class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <i class='bx bx-x bx-md'></i>
        </button>
    </div>
    <form id="edit-file-form" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-x-10">
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
                        <button type="button" id="add-edit-specification"
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
            @include('components.edit.specification-section')
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
    let selectedFileId; // Dynamically store the file ID
    // Dynamically store the permit type

    // Fetches file data dynamically
    async function fetchFileData(fileId) { // Replace with the actual file ID

        const url = `/api/files/${fileId}?includePermit=true`;
        try {
            const response = await fetch(url);
            const data = await response.json();
            console.log(data);

        } catch {

        }

    }
</script>
