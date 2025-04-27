<!-- An unexamined life is not worth living. - Socrates -->

<div id="edit-file-div" class="items-center justify-center mx-10">
    <div id="edit-content" class="">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-700">Edit File</h2>
            <button type="button" id="close-edit-btn" aria-controls="section-close-all" data-role="edit"
                class="close-all-btn toggle-btn hover:bg-red-200 p-3 rounded-full text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <form id="edit-file-form" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-x-10">


                @if ($type == 'local-transport-permit')
                    <div class="col-span-2 flex">
                        <div class="font-medium w-5/12">
                            <div class="my-4">
                                <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                                    Client</label>
                                <input type="text" id="edit-name-of-client" name="name_of_client"
                                    placeholder="Enter Value"
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

                            <div class="my-4">
                                <label for="business-farm-name"
                                    class="block mb-2 text-sm font-medium text-gray-700">Business Farm Name</label>
                                <input type="text" id="edit-business-farm-name" name="business_farm_name"
                                    placeholder="Enter Farm Name"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                                block w-full p-2.5 
                                                                                                                                focus:border-green-500 focus:ring-green-500 
                                                                                                                                required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                                valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p id="business-farm-name-error" class="mt-2 text-sm text-red-600 hidden">
                                    <span class="font-medium">Please!</span> Enter a valid business farm name
                                </p>
                            </div>

                            <div class="my-4">
                                <label for="butterfly-permit-number"
                                    class="block mb-2 text-sm font-medium text-gray-700">Butterfly Permit Number</label>
                                <input type="text" id="edit-butterfly-permit-number" name="butterfly_permit_number"
                                    placeholder="Enter Permit Number"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                                                        block w-full p-2.5 
                                                                                                                                                        focus:border-green-500 focus:ring-green-500 
                                                                                                                                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p id="butterfly-permit-number-error" class="mt-2 text-sm text-red-600 hidden">
                                    <span class="font-medium">Please!</span> Enter a valid business farm name
                                </p>
                            </div>

                            <div class="my-4">
                                <label for="destination"
                                    class="block mb-2 text-sm font-medium text-gray-700">Destination</label>
                                <input type="text" id="edit-destination" name="destination"
                                    placeholder="Enter Destination"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                                                                                block w-full p-2.5 
                                                                                                                                                                                focus:border-green-500 focus:ring-green-500 
                                                                                                                                                                                required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                                                                                valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p id="destination-error" class="mt-2 text-sm text-red-600 hidden">
                                    <span class="font-medium">Please!</span> Enter a valid Destination
                                </p>
                            </div>

                            <div class="my-4">
                                <label for="Date Applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                                    Applied</label>
                                <input type="date" id="edit-date-applied" name="date_applied"
                                    placeholder="Date Applied"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                                                        block w-full p-2.5 
                                                                                                                                                        focus:border-green-500 focus:ring-green-500 
                                                                                                                                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p id=-date-applied-error" class="mt-2 text-sm text-red-600 hidden">
                                    <span class="font-medium">Please!</span> Enter valid Date
                                </p>

                            </div>

                            <div class="my-4">
                                <label for="date-released" class="block mb-2 text-sm font-medium text-gray-700">Date
                                    Release</label>
                                <input type="date" id="edit-date-released" name="date_released"
                                    placeholder="Enter Date Release"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                            block w-full p-2.5 
                                                                            focus:border-green-500 focus:ring-green-500 
                                                                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                            </div>


                            <label for="classification"
                                class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                            <select id="edit-classification" name="classification"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                block w-full p-2.5 
                                                                                                                focus:border-green-500 focus:ring-green-500 
                                                                                                                required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required>
                                <option value="" disabled selected hidden>Select a Classification</option>
                                <option value="highly-technical">Highly Technical</option>
                                <option value="simple">Simple</option>
                            </select>



                            <input type="hidden" id="edit-office-source" name="office_source"
                                placeholder="Enter office source" value=null
                                class=" bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                            block w-full p-2.5 
                                                                                            focus:border-green-500 focus:ring-green-500 
                                                                                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required>
                        </div>

                        <div class="w-full">
                            <div class="max-w-lg mx-auto my-6">
                                <div class="flex gap-2">
                                    <input type="text" id="edit-searchInput" placeholder="Search butterfly..."
                                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                                    <button type="button" onclick="searchButterflies()"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Search</button>
                                </div>

                                <!-- Search Results -->
                                <ul id="edit-searchResults"
                                    class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-40 overflow-y-auto">
                                </ul>

                                <!-- Modal Backdrop -->
                                <div id="modalBackdropEdit" class="hidden fixed inset-0 bg-black bg-opacity-50"></div>

                                <!-- Add Butterfly Modal -->
                                <div id="addButterflyModalEdit"
                                    class="hidden fixed inset-0 flex justify-center items-center z-50">
                                    <div class="bg-white p-6 rounded-lg shadow-lg w-9/12 relative">
                                        <!-- Close Button (X Icon) -->
                                        <button onclick="closeModal()"
                                            class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                                            ✖
                                        </button>

                                        <h2 class="text-xl font-bold mb-4">Add New Butterfly</h2>
                                        <input type="text" id="newEditScientificName"
                                            placeholder="Scientific Name"
                                            class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                        <input type="text" id="newEditCommonName" placeholder="Common Name"
                                            class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                        <input type="text" id="newEditFamily" placeholder="Family"
                                            class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                        <input type="text" id="newEditGenus" placeholder="Genus"
                                            class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                        <textarea id="newEditDescription" placeholder="Description"
                                            class="w-full p-2 mb-2 border border-gray-300 rounded-lg"></textarea>
                                        <input type="text" id="newEditImageUrl" placeholder="Image URL"
                                            class="w-full p-2 mb-4 border border-gray-300 rounded-lg" />

                                        <button type="button" onclick="addButterflyEdit()"
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 w-full">Add
                                            Butterfly</button>
                                    </div>
                                </div>

                                <!-- Selected Butterflies Table -->
                                <div class="mt-4">
                                    <table class="w-full border-collapse border border-gray-200 rounded-lg shadow-md">
                                        <thead>
                                            <tr class="bg-green-500 text-white">
                                                <th class="py-2 px-4 text-left">Common/ScientificName</th>
                                                <th class="py-2 px-4 text-left">Quantity</th>
                                                <th class="py-2 px-4 text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit-selectedButterflies" class="bg-white"></tbody>
                                    </table>
                                </div>
                            </div>



                        </div>


                    </div>
                    <div class="mt-4 flex justify-end gap-4 col-span-2">
                        <button id="edit-btn" type="submit"
                            class="bg-green-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition duration-200">
                            <span id="button-spinner" class="hidden">
                                <svg aria-hidden="true" role="status"
                                    class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="#E5E7EB" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentColor" />
                                </svg>
                                Loading...
                            </span>
                            <span id="button-text">Update</span>
                        </button>
                    </div>
                @else
                    <!-- step 1 -->
                    <div class="font-medium ">
                        @if (!$record)
                            <div class="my-4">
                                <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name
                                    of
                                    Client</label>
                                <input type="text" id="edit-name-of-client" name="name_of_client"
                                    placeholder="Enter value"
                                    class="name-of-client bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                block w-full p-2.5 
                                focus:border-green-500 focus:ring-green-500 
                                required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                            </div>
                        @endif
                        <div class="my-4">
                            <label for="office-source" class="block mb-2 text-sm font-medium text-gray-700">Office
                                Source</label>
                            <input type="text" id="edit-office-source" name="office_source"
                                placeholder="Enter office source"
                                class="office-source bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required>
                            <p id="office-source-error" class="mt-2 text-sm text-red-600 hidden">
                                <span class="font-medium">Please!</span> Enter valid input!
                            </p>
                        </div>
                        @if ($type == 'tree-cutting-permits')
                            <label for="tcp-type" class="block mb-2 text-sm font-medium text-gray-700">Tree Cutting
                                Permit Type</label>
                            <select id="edit-permit-type" name="permit_type"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                    block w-full p-2.5 
                                                                    focus:border-green-500 focus:ring-green-500 
                                                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required>
                                <option value="" disabled selected hidden>Choose Tree Cutting Permit</option>
                                <option value="Special Tree Cutting Permit">Special Tree Cutting Permit</option>
                                <option value="Tree Cutting Permit for planted/naturally growing growing trees">Tree
                                    Cutting Permit for
                                    planted/naturally growing trees</option>
                                <option value="Private Land Timber Permit">Private Land Timber Permit(PLTP)</option>
                                <option value="Special Private Land Timber Permit">Special Private Land Timber
                                    Permit(SPLTP)
                                </option>
                            </select>
                        @endif

                        <div class="my-4">
                            @if ($type == 'land-title')
                                @if ($municipality == 'Santa Cruz')
                                    {{-- Content specific for Sta Cruz --}}
                                    <label for="classification"
                                        class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                    <select id="edit-classification" name="classification"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                        <option value="" disabled selected>Select a Classification</option>
                                        <option value="PLS 726">PLS 726</option>
                                        <option value="CAD 815">CAD 815</option>
                                        <option value="PSC4">PSC4</option>
                                    </select>
                                @elseif ($municipality == 'Torrijos')
                                    {{-- Content specific for Torrijos --}}
                                    <label for="classification"
                                        class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                    <select id="edit-classification" name="classification"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                        <option value="" disabled selected>Select a Classification</option>
                                        <option value="PLS 783">PLS 783</option>
                                        <option value="CAD 612">CAD 612</option>
                                    </select>
                                @else
                                    {{-- Content for other municipalities --}}
                                    <label for="classification"
                                        class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                    <select id="edit-classification" name="classification"
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
                                @endif
                            @else
                                {{-- Content for types other than land-title --}}
                                <label for="classification"
                                    class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                <select id="edit-classification" name="classification"
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


                                <div class="my-4">
                                    <label for="date-released"
                                        class="block mb-2 text-sm font-medium text-gray-700">Date
                                        Release</label>
                                    <input type="date" id="edit-date-released" name="date_released"
                                        placeholder="Enter Date Release"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                            block w-full p-2.5 
                                                                            focus:border-green-500 focus:ring-green-500 
                                                                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                </div>


                            @endif
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
                                    <svg class="size-5 text-red-700 font-extrabold" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Click to Add
                                </button>
                            </div>
                            <!-- Show species for tree-cutting-permits, transport-permit -->

                            <!-- this for pop up modal for adding no. of trees/species/location/date applied/ -->
                        @elseif ($type == 'chainsaw-registration')
                            <!-- Location Field -->
                            <div class="my-4">
                                <label for="location"
                                    class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                <input type="text" id="edit-location" name="location"
                                    class="location bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter location">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Serial Number Field -->
                            <div class="my-4">
                                <label for="serial_number" class="block mb-2 text-sm font-medium text-gray-700">Serial
                                    Number</label>
                                <input type="text" id="edit-serial-number" name="serial_number"
                                    class="serial-number bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter serial number">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Date Applied Field -->
                            <div class="my-4">
                                <label for="date_applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                                    Applied</label>
                                <input type="date" id="edit-date-applied" name="date_applied"
                                    class="date-applied bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>
                        @elseif ($type == 'tree-plantation-registration')
                            <!-- Number of Trees Field -->
                            <div class="my-4">
                                <label for="number_of_trees" class="block mb-2 text-sm font-medium text-gray-700">No.
                                    of Trees</label>
                                <input type="number" id="edit-number-of-trees" name="number_of_trees"
                                    class="number-of-trees bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter number of trees">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Location Field -->
                            <div class="my-4">
                                <label for="location"
                                    class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                <input type="text" id="edit-location" name="location"
                                    class="location bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter location">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Date Applied Field -->
                            <div class="my-4">
                                <label for="date_applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                                    Applied</label>
                                <input type="date" id="edit-date-applied" name="date_applied"
                                    class="date-applied bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <div class="my-4">
                                <label for="date_applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                                    Applied</label>
                                <input type="date" id="edit-date-applied" name="date_applied"
                                    class="date-applied bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>
                        @elseif ($type == 'transport-permit')
                            <!-- Transport Permits Inputs -->
                            <div class="my-4">
                                <h2 class="block mb-2 text-sm font-medium text-gray-700">Add Tree
                                    Specification</h2>
                                <button type="button" id="add-edit-specification"
                                    class="text-blue-700 mb-2 bg-blue-100 border border-blue-400 hover:bg-blue-200 focus:ring-2  focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2">
                                    <svg class="size-5 text-red-700 font-extrabold" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Click to Add
                                </button>
                            </div>
                        @elseif ($type == 'land-title')
                            <!-- Location Field -->
                            <div class="my-4">
                                <label for="location"
                                    class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                <input type="text" id="edit-location" name="location"
                                    class="location bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter location">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Lot Number Field -->
                            <div class="my-4">
                                <label for="lot_number" class="block mb-2 text-sm font-medium text-gray-700">Lot
                                    Number</label>
                                <input type="text" id="edit-lot-number" name="lot_number"
                                    class="lot-number bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                            block w-full p-2.5 
                            focus:border-green-500 focus:ring-green-500 
                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required placeholder="Enter lot number">
                                <p class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span>
                                    Enter
                                    valid
                                    input!</p>
                            </div>

                            <!-- Property Category Field -->
                        @endif
                    </div>
                    @include('components.edit.specification-section')
                    <div class="mt-4 flex justify-end gap-4 col-span-2">
                        <button id="edit-btn" type="submit"
                            class="bg-green-500 text-white rounded-md px-4 py-2 hover:bg-green-600 transition duration-200">
                            <span id="button-spinner" class="hidden">
                                <svg aria-hidden="true" role="status"
                                    class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="#E5E7EB" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentColor" />
                                </svg>
                                Loading...
                            </span>
                            <span id="button-text">Update</span>
                        </button>
                    </div>

                @endif
            </div>


        </form>
    </div>
    <div id="skeleton" role="status" class="w-full animate-pulse hidden pt-4">
        <div class="h-2.5 bg-gray-200 rounded-full mb-4"></div>
        <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full mb-2.5"></div>
        <div class="h-2 bg-gray-200 rounded-full max-w-[360px]"></div>
        <span class="sr-only">Loading...</span>
    </div>
</div>

<script>
    // Fetches file data dynamically

    async function fetchEditFile(fileId) {
        initializeButterfly(fileId);
        let includePermit = {!! json_encode($includePermit ?? '') !!};

        const editContent = document.getElementById("edit-content");
        const skeleton = document.getElementById("skeleton");

        editContent.classList.add("hidden");
        skeleton.classList.remove("hidden");

        //includePermit boolean if file have permit Y/N

        const url = `/api/files/${fileId}?includePermit=${includePermit}`;
        try {
            const response = await fetch(url);

            if (!response.ok) throw new Error("You failed to fetch the data and permit");

            const data = await response.json();


            if (data.success) {
                console.log(data);
                //    
                const editForm = document.getElementById('edit-file-form');
                editForm.dataset.fileId = fileId; // Set fileId in data-file-id
                // Handle `file` properties
                Object.entries(data.file).forEach(([key, value]) => {

                    const idSelector = key.replace(/_/g, '-'); // Prepare the class name selector
                    // Select all elements with the corresponding class and update their value
                    const input = document.getElementById(`edit-${idSelector}`);
                    if (input) {
                        input.value = value;
                    }
                });

                // Handle `permit` properties (if it exists)
                if (data.permit) {
                    console.log(data.permit);
                    Object.entries(data.permit).forEach(([key, value]) => {
                        const idSelector = key.replace(/_/g, '-'); // Prepare the class name selector
                        // Select all elements with the corresponding class and update their value
                        const input = document.getElementById(`edit-${idSelector}`);

                        if (input) {
                            input.value = value;
                        }
                    });

                    if (data.permit.details) {
                        // const specificationTemplate = document.querySelectorAll('.file-specification-box');
                        // if (specificationTemplate) {
                        //     specificationTemplate.innerHTML = "";
                        // }

                        const details = data.permit.details;
                        console.log('wthis is', details);
                        for (let index = 0; index < details.length; index++) {
                            const detail = details[index];

                            const existingTemplate = document.querySelector(`#file-specification-box-${index}`);
                            if (!existingTemplate) {
                                editSpecification(); // Clone only if it doesn't exist
                            }


                            const deleteBtn = document.querySelector(`#delete-specification-${index}`);
                            const closeBtn = document.querySelector(`#close-specification-${index}`);


                            // Find the newly cloned delete button
                            Object.entries(detail).forEach(async ([key, value]) => {
                                const input = document.querySelector(`[id="${key}[${index}]"]`);
                                if (input) {
                                    if (input.tagName === 'SELECT' && key === 'species') {
                                        // Fetch options first
                                        await fetchTreeSpeciesEdit(input, defaultValue = value);
                                        input.value = value; // now this will work
                                    } else {
                                        input.value = value;
                                    }
                                }

                                if (closeBtn) {
                                    closeBtn.classList.add("hidden");
                                }
                            });
                            if (deleteBtn) {
                                deleteBtn.classList.remove('hidden');

                                deleteBtn.addEventListener("click", function() {
                                    const detailId = detail.id;
                                    deleteDetail(detailId);
                                    console.log("Deleting specification with ID: ", detail.id);
                                });

                            }
                        }
                    }
                }
            } else {
                console.error('API Error:', data.message); // Log the error if the API call failed
            }
        } catch (error) {
            console.error("Error fetching data:", error); // Log any errors that occur
        } finally {
            editContent.classList.remove("hidden");
            skeleton.classList.add("hidden");
        }

    }


    //upload the edited file and permits
    document.getElementById('edit-file-form').addEventListener('submit', async function(event) {
        event.preventDefault();
        const csrfToken = "{{ csrf_token() }}";
        const fileId = event.target.dataset.fileId;
        document.getElementById('edit-file-form').classList.add('pointer-events-none', 'opacity-50');
        //parameters

        let authId = {!! json_encode($authId) !!};
        let type = {!! json_encode($type ?? '') !!};
        let municipality = {!! json_encode($municipality) !!};

        const params = {
            type: type
        };

        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );
        // console.log("Params Before Filtering:", params);
        // Build the query string
        const queryParams = new URLSearchParams(filteredParams).toString();
        let butterflies = []

        if (type == 'local-transport-permit') {

            butterflies = getSelectedButterflies();
            console.log(butterflies)

            if (butterflies.length === 0) {
                showToast({
                    type: 'failed',
                    message: 'Please select at least one butterfly before proceeding..',

                });
                buttonText.classList.remove('hidden');
                buttonSpinner.classList.add('hidden');
                uploadButton.disabled = false;
                return; // Stop execution if the array is empty
            }
        }

        // FormData will automatically group inputs like `details[0][species]`
        const formData = new FormData(this);

        try {
            const editFileResponse = await fetch(`/api/files/update/${fileId}?${queryParams}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!editFileResponse.ok) throw new Error("File Update failed");
            const response = await editFileResponse.json();

            try {
                if (type == 'local-transport-permit') {

                    fetch(`/api/file/sync-butterflies/${fileId}`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                butterflies
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log("Success:", data))
                        .catch(error => console.error("Error:", error));


                    // document.getElementById("edit-selectedButterflies").innerHTML = ""; // Clear table
                    document.getElementById("edit-searchInput").value = ""; // Clear search input
                    document.getElementById("edit-searchResults").innerHTML = ""; // Clear search results

                }


            } catch (error) {
                showToast({
                    type: 'danger',
                    message: 'Failed to update butterfly details.',

                });
            }

            showToast({
                type: 'success',
                message: 'Success! The edit is complete.',

            });
            closeAllSections();
        } catch (error) {
            showToast({
                type: 'danger',
                message: 'Failed to edit the file.',

            });

        } finally {
            document.getElementById('edit-file-form').classList.remove('pointer-events-none', 'opacity-50');
        }
    });

    function deleteDetail(id) {
        const csrfToken = "{{ csrf_token() }}"; // Laravel CSRF token

        let type = {!! json_encode($type ?? '') !!};
        const params = {
            type: type
        };

        // Filter and build query string
        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );
        const queryParams = new URLSearchParams(filteredParams).toString();

        fetch(`/api/delete/details/${id}?${queryParams}`, {
                method: 'DELETE', // Use DELETE method, not POST
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Include CSRF token for security
                },
            })
            .then((response) => response.json())
            .then((data) => {
                showToast({
                    type: 'success',
                    message: 'Success! The specification is deleted.',

                });

            })
            .catch((error) => {
                showToast({
                    type: 'danger',
                    message: 'Unable to delete the selected detail.',

                });

            });
    }




    async function initializeButterfly(fileId) {
        try {
            // 68const fileId = document.getElementById("someElement")?.dataset.fileId;
            if (!fileId) throw new Error("File ID is missing");
            const tableBody = document.getElementById("edit-selectedButterflies");
            if (tableBody) tableBody.innerHTML = "";
            const response = await fetch(`/api/files/${fileId}/butterflies`);
            const data = await response.json();

            data.forEach(butterfly => addToTableEdit(butterfly, true));
        } catch (error) {
            console.error("Error in initializeTable:", error);
        }
    }


    function searchButterflies() {
        let query = document.getElementById("edit-searchInput").value;
        fetch(`/api/butterflies/search?query=${query}`)
            .then(response => response.json())
            .then(data => {
                let resultsList = document.getElementById("edit-searchResults");
                resultsList.innerHTML = ""; // Clear previous results

                if (data.length === 0) {
                    document.getElementById("modalBackdropEdit").classList.remove("hidden"); // Show backdrop
                    document.getElementById("addButterflyModalEdit").classList.remove("hidden"); // Show modal
                    return;
                }

                data.forEach(butterfly => {
                    let li = document.createElement("li");
                    li.textContent = butterfly.common_name + ' / ' + butterfly.scientific_name;
                    li.className = "p-2 cursor-pointer hover:bg-blue-100 border-b";
                    li.onclick = function() {
                        addToTableEdit(butterfly);
                    };
                    resultsList.appendChild(li);
                });
            })
            .catch(error => console.error("Error fetching data:", error));
    }

    function addToTableEdit(butterfly, isInitialLoad = false) {
        let tableBody = document.getElementById("edit-selectedButterflies");

        // Prevent duplicates
        let existingRows = tableBody.querySelectorAll("tr");
        for (let row of existingRows) {
            if (row.getAttribute("data-id") === butterfly.id.toString()) {
                if (!isInitialLoad) alert("Already added!");
                return;
            }
        }

        let row = document.createElement("tr");
        row.setAttribute("data-id", butterfly.id);
        row.className = "border-b border-gray-200";
        row.innerHTML = `
                <td class="py-2 px-4">${butterfly.common_name} / ${butterfly.scientific_name}</td>
                <td class="py-2 px-4">
                    <input type="number" value="${butterfly.quantity || 1}" 
                        class="w-6/12 p-1 border border-gray-300 rounded-lg focus:ring-green-500" />
                </td>
                <td class="py-2 px-4">
                    <button onclick="removeRow(this)" 
                        class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i class='bx bxs-trash-alt'></i>
                    </button>
                </td>
            `;
        tableBody.appendChild(row);
    }

    function removeRow(button) {
        button.closest("tr").remove();
    }

    function addButterflyEdit() {
        let scientific_name = document.getElementById("newEditScientificName").value;
        let common_name = document.getElementById("newEditCommonName").value;
        let family = document.getElementById("newEditFamily").value;
        let genus = document.getElementById("newEditGenus").value;
        let description = document.getElementById("newEditDescription").value;
        let image_url = document.getElementById("newEditImageUrl").value;

        fetch('/butterfly/add', { // <-- Ensure this matches your Laravel route
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    scientific_name,
                    common_name,
                    family,
                    genus,
                    description,
                    image_url
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                // Add the newly created butterfly to the table
                addToTableEdit(data.butterfly);

                // Clear the input fields
                document.getElementById("newEditScientificName").value = "";
                document.getElementById("newEditCommonName").value = "";
                document.getElementById("newEditFamily").value = "";
                document.getElementById("newEditGenus").value = "";
                document.getElementById("newEditDescription").value = "";
                document.getElementById("newEditImageUrl").value = "";

                closeModal();
            })
            .catch(error => {
                console.error("Error adding butterfly:", error);
                showToast({
                    type: 'failed',
                    message: 'Failed to add butterfly. Please check the input.',

                });

            });
    }

    function closeModal() {
        document.getElementById("addButterflyModalEdit").classList.add("hidden");
        document.getElementById("modalBackdropEdit").classList.add("hidden"); // Hide backdrop
    }


    function getSelectedButterflies() {
        let butterflies = [];

        document.querySelectorAll("#edit-selectedButterflies tr").forEach(row => {
            let id = row.getAttribute("data-id"); // Get the data-id attribute
            let name = row.cells[0].innerText.trim(); // Get Common/Scientific Name
            let quantityInput = row.cells[1].querySelector("input"); // Input field in Quantity column

            if (quantityInput) {
                let quantity = parseInt(quantityInput.value) || 0; // Get the quantity value
                butterflies.push({
                    id,
                    name,
                    quantity
                });
            }
        });

        console.log(butterflies); // Debugging output
        return butterflies;
    }
</script>
