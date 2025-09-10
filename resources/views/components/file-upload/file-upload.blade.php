<!-- Life is available only in the present moment. - Thich Nhat Hanh -->

<div class="items-center justify-center mx-10">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold text-gray-700">Upload File</h2> {{-- add summary --}}
        <button type="button" id="close-upload-btn" aria-controls="section-close-all" data-role="upload"
            class="close-all-btn toggle-btn hover:bg-red-200 p-3 rounded-full text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
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

            @if ($type == 'local-transport-permit')
                <div class="col-span-2 flex">
                    <div class="font-medium w-5/12">
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

                        <div class="my-4">
                            <label for="business-farm-name"
                                class="block mb-2 text-sm font-medium text-gray-700">Business Farm Name</label>
                            <input type="text" id="business-farm-name" name="business_farm_name"
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
                            <input type="text" id="butterfly-permit-number" name="butterfly_permit_number"
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
                            <input type="text" id="destination" name="destination" placeholder="Enter Destination"
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
                            <input type="date" id="date_applied" name="date_applied" placeholder="Date Applied"
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
                            <input type="date" id="date-released" name="date_released"
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
                        <select id="classification" name="classification"
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



                        <input type="hidden" id="office-source" name="office_source"
                            placeholder="Enter office source" value=''
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
                                <input type="text" id="searchInput" placeholder="Search butterfly..."
                                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                                <button type="button" onclick="searchButterfliesAdd()"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Search</button>
                            </div>

                            <!-- Search Results -->
                            <ul id="searchResults"
                                class="mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-40 overflow-y-auto">
                            </ul>

                            <!-- Modal Backdrop -->
                            <div id="modalBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-50"></div>

                            <!-- Add Butterfly Modal -->
                            <div id="addButterflyModal"
                                class="hidden fixed inset-0 flex justify-center items-center z-50">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-9/12 relative">
                                    <!-- Close Button (X Icon) -->
                                    <button type="button" onclick="closeModalAdd()"
                                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">
                                        ✖
                                    </button>

                                    <h2 class="text-xl font-bold mb-4">Add New Butterfly</h2>
                                    <input type="text" id="newScientificName" placeholder="Scientific Name"
                                        class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                    <input type="text" id="newCommonName" placeholder="Common Name"
                                        class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                    <input type="text" id="newFamily" placeholder="Family"
                                        class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                    <input type="text" id="newGenus" placeholder="Genus"
                                        class="w-full p-2 mb-2 border border-gray-300 rounded-lg" />
                                    <textarea id="newDescription" placeholder="Description" class="w-full p-2 mb-2 border border-gray-300 rounded-lg"></textarea>
                                    <input type="text" id="newImageUrl" placeholder="Image URL"
                                        class="w-full p-2 mb-4 border border-gray-300 rounded-lg" />

                                    <button type="button" onclick="addButterflyOnUpload()"
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
                                    <tbody id="selectedButterflies" class="bg-white"></tbody>
                                </table>
                            </div>
                        </div>

                        <script>
                            function searchButterfliesAdd() {

                                let query = document.getElementById("searchInput").value;
                                console.log("HELLO", query)
                                fetch(`/api/butterflies/search?query=${query}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        let resultsList = document.getElementById("searchResults");
                                        resultsList.innerHTML = ""; // Clear previous results

                                        if (data.length === 0) {
                                            document.getElementById("modalBackdrop").classList.remove("hidden"); // Show backdrop
                                            document.getElementById("addButterflyModal").classList.remove("hidden"); // Show modal
                                            return;
                                        }

                                        data.forEach(butterfly => {
                                            let li = document.createElement("li");
                                            li.textContent = butterfly.common_name + ' / ' + butterfly.scientific_name;
                                            li.className = "p-2 cursor-pointer hover:bg-blue-100 border-b";
                                            li.onclick = function() {
                                                addToTableAdd(butterfly);
                                            };
                                            resultsList.appendChild(li);
                                        });
                                    })
                                    .catch(error => console.error("Error fetching data:", error));
                            }

                            function addToTableAdd(butterfly) {
                                let tableBody = document.getElementById("selectedButterflies");

                                // Prevent duplicates
                                let existingRows = tableBody.querySelectorAll("tr");
                                for (let row of existingRows) {
                                    if (row.getAttribute("data-id") === butterfly.id.toString()) {
                                        alert("Already added!");
                                        return;
                                    }
                                }

                                let row = document.createElement("tr");
                                row.setAttribute("data-id", butterfly.id);
                                row.className = "border-b border-gray-200";
                                row.innerHTML = `<td class="py-2 px-4">${butterfly.common_name} / ${butterfly.scientific_name}</td>
                                                                                    <td class="py-2 px-4">
                                                                                    <input type="number" value=1 
                                        class="w-6/12 p-1 border border-gray-300 rounded-lg focus:ring-green-500" /></td>
                                                                                    <td class="py-2 px-4">
                                                                                        <button onclick="removeRow(this)" 
                                                                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600"><i class='bx bxs-trash-alt'></i></button>
                                                                                    </td>`;
                                tableBody.appendChild(row);
                            }

                            function removeRow(button) {
                                button.closest("tr").remove();
                            }

                            function addButterflyOnUpload() {
                                let scientific_name = document.getElementById("newScientificName").value;
                                let common_name = document.getElementById("newCommonName").value;
                                let family = document.getElementById("newFamily").value;
                                let genus = document.getElementById("newGenus").value;
                                let description = document.getElementById("newDescription").value;
                                let image_url = document.getElementById("newImageUrl").value;

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
                                        addToTableAdd(data.butterfly);

                                        // Clear the input fields
                                        document.getElementById("newScientificName").value = "";
                                        document.getElementById("newCommonName").value = "";
                                        document.getElementById("newFamily").value = "";
                                        document.getElementById("newGenus").value = "";
                                        document.getElementById("newDescription").value = "";
                                        document.getElementById("newImageUrl").value = "";

                                        closeModalAdd();
                                    })
                                    .catch(error => {
                                        console.error("Error adding butterfly:", error);
                                        showToast({
                                            type: 'failed',
                                            message: 'Failed to add butterfly. Please check the input.',
                                        });

                                    });
                            }

                            function closeModalAdd() {
                                document.getElementById("addButterflyModal").classList.add("hidden");
                                document.getElementById("modalBackdrop").classList.add("hidden"); // Hide backdrop
                            }
                        </script>

                    </div>
                </div>



                <!-- step 1 -->
            @else
                <div class="font-medium ">
                    @if (!$record)
                        <div class="my-4">
                            <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                                Client</label>
                            <input type="text" id="name-of-client" name="name_of_client"
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
                    @endif
                    <div class="my-4">
                        <label for="office-source" class="block mb-2 text-sm font-medium text-gray-700">Document
                            Office
                            Source</label>
                        <input type="text" id="office-source" name="office_source"
                            placeholder="Enter office source"
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
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Document Title</label>
                        <input type="text" id="title" name="title"
                            placeholder="Enter Document Title"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                            block w-full p-2.5 
                                            focus:border-green-500 focus:ring-green-500 
                                            required:border-gray-500 required:ring-gray-500 required:text-gray-500 required:placeholder:text-gray-500
                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                        <p id="office-source-error" class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter valid input!</p>
                    </div>

                    <div class="my-4">
                        <label for="control_no" class="block mb-2 text-sm font-medium text-gray-700">Document Control No.</label>
                        <input type="text" id="control_no" name="control_no"
                            placeholder="Enter Document Control No."
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                            block w-full p-2.5 
                                            focus:border-green-500 focus:ring-green-500 
                                            required:border-gray-500 required:ring-gray-500 required:text-gray-500 required:placeholder:text-gray-500
                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                        <p id="office-source-error" class="mt-2 text-sm text-red-600 hidden"><span class="font-medium">Please!</span> Enter valid input!</p>
                    </div>

                    <div class="my-4">
                        @if ($type == 'land-title')
                            @if ($municipality == 'Santa Cruz')
                                {{-- Content specific for Sta Cruz --}}
                                <label for="classification"
                                    class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                <select id="classification" name="classification"
                                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                block w-full p-2.5 
                                                focus:border-green-500 focus:ring-green-500 
                                                required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                    autocomplete="off" required>
                                    <option disabled selected hidden>Select a Classification</option>
                                    <option value="PLS 726">PLS 726</option>
                                    <option value="CAD 815">CAD 815</option>
                                    <option value="PSC4">PSC4</option>
                                </select>
                            @elseif ($municipality == 'Torrijos')
                                {{-- Content specific for Torrijos --}}
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
                                    <option value="PLS 783">PLS 783</option>
                                    <option value="CAD 612">CAD 612</option>
                                </select>
                            @else
                                {{-- Content for other municipalities --}}
                                <label for="classification"
                                    class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                                <select id="classification" name="classification"
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
                            @endif
                        @else
                            {{-- Content for types other than land-title --}}
                            <label for="classification"
                                class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                            <select id="classification" name="classification"
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
                        @endif
                    </div>

                    <div class="my-4">
                        @if ($type == 'tree-cutting-permits')
                            <label for="tcp-type" class="block mb-2 text-sm font-medium text-gray-700">Tree Cutting
                                Permit Type</label>
                            <select id="tcp-type" name="tcp-type"
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
                    </div>

                    <div class="my-4">
                        <label for="date-released" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Release</label>
                        <input type="date" id="date-released" name="date_released"
                            placeholder="Enter Date Release"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                                                                                            block w-full p-2.5 
                                                                                                                            focus:border-green-500 focus:ring-green-500 
                                                                                                                            required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                                                                                            valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            autocomplete="off" required>
                    </div>

                </div>
                <!-- step 2 -->
                <div class="font-medium">
                    @if ($type == 'tree-cutting-permits')
                        <div class="my-4">
                            <h2 class="block mb-2 text-sm font-medium text-gray-700">Add Tree Cutting Specification
                            </h2>
                            <button type="button" id="add-file-specification"
                                class="text-blue-700 mb-2 bg-blue-100 border border-blue-400 hover:bg-blue-200 focus:ring-2  focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2">
                                <svg class="size-5 text-red-700 font-extrabold" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                                Click to Add
                            </button>
                        </div>
                        <!-- Show species for tree-cutting-permits, transport-permit -->

                        <!-- this for pop up modal for adding no. of trees/species/location/date applied/ -->
                    @elseif ($type == 'chainsaw-registration')
                        <!-- Location Field -->
                        <div class="my-4">
                            <label for="location" id="label-location"
                                class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                        block w-full p-2.5 
                                                        focus:border-green-500 focus:ring-green-500 
                                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required placeholder="Enter Location">
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
                    @elseif ($type == 'tree-plantation-registration')
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
                            <label for="location" id="label-location"
                                class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                        block w-full p-2.5 
                                                        focus:border-green-500 focus:ring-green-500 
                                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required placeholder="Enter Location">
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

                       <div class="my-4">
                            <label for="species" class="block mb-2 text-sm font-medium text-gray-700">Species</label>
                            <select id="species" name="species"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500 required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required>
                                <!-- Options will be dynamically populated -->
                            </select>
                        </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", async () => {
                                    const speciesSelect = document.getElementById('species');
                                    try {
                                        const response = await fetch('/api/tree-species');
                                        if (response.ok) {
                                            const data = await response.json();
                                            speciesSelect.innerHTML = '<option value="" disabled selected hidden>Select a species</option>';
                                            data.forEach(species => {
                                                const option = document.createElement('option');
                                                option.value = species.common_name;
                                                option.textContent = species.common_name;
                                                speciesSelect.appendChild(option);
                                            });
                                        }
                                    } catch (error) {
                                        console.error('Failed to fetch species', error);
                                    }
                                });
                            </script>


                        
                    @elseif ($type == 'transport-permit')
                        <!-- Transport Permits Inputs -->
                        <div class="my-4">
                            <h2 class="block mb-2 text-sm font-medium text-gray-700">Add Tree Transport
                                Specification</h2>
                            <button type="button" id="add-file-specification"
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
                            <label for="location" id="label-location"
                                class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                                        block w-full p-2.5 
                                                        focus:border-green-500 focus:ring-green-500 
                                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                autocomplete="off" required placeholder="Enter Location">
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
            @endif
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
    const fileUploadTitle = document.getElementById('title');


    function validateFile() {
        const file = fileInput.files[0];


        if (fileInput.files.length === 0) {
            fileUploadError.textContent = "Please upload a file.";
            fileUploadError.classList.remove('invisible');
            return false;
        }
        const allowedTypes = [
            'application/pdf',
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
             console.log(selectedFile);
            fileUploadName.textContent = selectedFile.name; // Update Step 1
            // fileUploadTitle.value = selectedFile.name;
            fileUploadError.classList.add('invisible'); // Hide error if file is chosen
        } else {
            fileUploadName.textContent = 'No file chosen'; // Reset if no file is chosen
            fileUploadError.classList.remove('invisible'); // Show error if no file is chosen
        }
    });



    let fileId;
    let canUpload = false;

    const addFileSpecificationButton = document.getElementById('add-file-specification');

    if (addFileSpecificationButton) {
        addFileSpecificationButton.addEventListener('click', function() {

            canUpload = true;
        });
    }



    document.getElementById('upload-form').addEventListener('submit', async function(event) {
        event.preventDefault();
        //filter if not add specs

        if (!addFileSpecificationButton) {
            canUpload = true;
        }

        if (!canUpload) {
            showToast({
                type: 'danger',
                message: 'Add file specification before uploading.',

            }); //update the toast here
            return;
        }

        const csrfToken = "{{ csrf_token() }}";
        const uploadButton = document.getElementById('upload-btn');
        const buttonText = document.getElementById('button-text');
        const buttonSpinner = document.getElementById('button-spinner');



        uploadButton.disabled = true;
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
            isArchived: isArchived,

        };

        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([key, value]) => value !== '')
        );
        // console.log("Params Before Filtering:", params);
        // Build the query string
        const queryParams = new URLSearchParams(filteredParams).toString();

        //console.log('this', queryParams);
        const formData = new FormData(this);
        
        let butterfliesAdd = []; // Collect selected butterfly data

        if (type == 'local-transport-permit') {
            butterfliesAdd = getSelectedButterfliesAdd();


            if (butterfliesAdd.length === 0) {
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
        console.log(formData);

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
            console.log(fileResponseData);
            const fileId = fileResponseData.fileId; // Ensure `fileId` is in the response
            refreshTable();
            // Check if permit data exists before proceeding
            if (type !== undefined && type !== null && type !== '') {
                const permitData = new FormData(this);
                permitData.append('file_id', fileId);

                const permitUploadResponse = await fetch(`/permit-upload?${queryParams}`, {
                    method: 'POST',
                    body: permitData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (type == 'local-transport-permit') {
                    console.log(butterfliesAdd)
                    fetch(`/api/files/${fileId}/butterfly-details`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                butterflies: butterfliesAdd
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log("Success:", data))
                        .catch(error => console.error("Error:", error));


                    document.getElementById("selectedButterflies").innerHTML = ""; // Clear table
                    document.getElementById("searchInput").value = ""; // Clear search input
                    document.getElementById("searchResults").innerHTML = ""; // Clear search results

                }


                if (!permitUploadResponse.ok) throw new Error("Permit upload failed");

                refreshTable();
            }
            const specification = document.querySelectorAll('.file-specification-box');
            if (specification) {
                specification.forEach(template => {
                    template.remove();
                });
            }
            showToast({
                type: 'success',
                message: 'Success! The upload is complete.',

            });

            buttonText.classList.remove('hidden');
            buttonSpinner.classList.add('hidden');
            document.getElementById('file-upload-name').textContent = 'No file chosen';
            uploadButton.disabled = false;
            this.reset();
        } catch (error) {
            console.log(error);
            showToast({
                type: 'danger',
                message: 'Upload unsuccessful. Check your file name if there are duplicate or file format and try again.',
                // message: error.message
            });
            uploadButton.disabled = false;
            // this.reset();
            buttonText.classList.remove('hidden');
            buttonSpinner.classList.add('hidden');
        }
    });

    function getSelectedButterfliesAdd() {
        let butterfliesAdd = [];

        document.querySelectorAll("#selectedButterflies tr").forEach(row => {
            let id = row.getAttribute("data-id"); // Get the data-id attribute
            let name = row.cells[0].innerText.trim(); // Get Common/Scientific Name
            let quantityInput = row.cells[1].querySelector("input"); // Input field in Quantity column

            if (quantityInput) {
                let quantity = parseInt(quantityInput.value) || 0; // Get the quantity value
                butterfliesAdd.push({
                    id,
                    name,
                    quantity
                });
            }
        });

        console.log(butterfliesAdd); // Debugging output
        return butterfliesAdd;
    }
    // if (type !== "tree-cutting-permits" || report == null) {

    //     document.addEventListener('DOMContentLoaded', async function() {
    //         const locationSelect = document.getElementById('location');
    //         const errorMessage = document.getElementById('error-message');
    //         const currentPath = window.location.pathname;
    //         const currentMunicipality = currentPath.split('/').pop();

    //         try {
    //             // Fetch all municipalities
    //             const municipalityResponse = await fetch(
    //                 'https://psgc.gitlab.io/api/provinces/174000000/municipalities/');
    //             if (!municipalityResponse.ok) {
    //                 throw new Error('Failed to fetch municipalities');
    //             }

    //             const municipalities = await municipalityResponse.json();

    //             // Ensure the response is an array
    //             if (!Array.isArray(municipalities)) {

    //             }

    //             // Match the current municipality by name
    //             const matchedMunicipality = municipalities.find(
    //                 (municipality) => municipality.name.toLowerCase() === currentMunicipality
    //                 .toLowerCase()
    //             );

    //             if (!matchedMunicipality) {
    //                 return;
    //             }

    //             console.log(`Matched Municipality:`, matchedMunicipality);



    //             // Use the `code` to fetch barangays
    //             const barangayResponse = await fetch(
    //                 `https://psgc.gitlab.io/api/municipalities/${matchedMunicipality.code}/barangays/`

    //             );
    //             if (!barangayResponse.ok) {
    //                 throw new Error('Failed to fetch barangays');
    //             }

    //             const barangays = await barangayResponse.json();

    //             // Populate the barangay dropdown
    //             locationSelect.innerHTML = '<option value="" disabled selected>Select a barangay</option>';
    //             barangays.forEach(barangay => {
    //                 const option = document.createElement('option');
    //                 option.value = barangay.id || barangay.name; // Adjust based on API structure
    //                 option.textContent = barangay.name;
    //                 locationSelect.appendChild(option);
    //             });

    //             errorMessage.classList.add('hidden');
    //         } catch (error) {
    //             console.error('Error:', error);

    //             if (errorMessage) {
    //                 errorMessage.classList.remove('hidden');
    //                 locationSelect.innerHTML =
    //                     '<option value="" disabled selected>Error loading options</option>';
    //             }

    //         }
    //     });
    // }
</script>
