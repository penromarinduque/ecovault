<div id="upload-file-div" class="items-center justify-center">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold text-gray-700">Upload File</h2> {{-- add summary --}}
        <button type="button" id="close-upload-btn"
            class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <i class='bx bx-x bx-md'></i>
        </button>
    </div>
    <form id="upload-form" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 space-x-4">
            <div class="col-span-2 ">
                <div class="flex items-center space-x-4">
                    <label class="block mt-2">
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
            </div>
            <!-- step 1 -->
            <div class="font-medium ">

                <div class="my-4">
                    <label for="office-source" class="block mb-2 text-sm font-medium text-gray-700">Office
                        Source</label>
                    <input type="text" id="office-source" name="office_source"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
            block w-full p-2.5 
            focus:border-green-500 focus:ring-green-500 
            required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
            valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                        placeholder="Enter office source" required>
                    <p id="office-source-error" class="mt-2 text-sm text-red-600 hidden">
                        <span class="font-medium">Please!</span> Enter valid input!
                    </p>
                </div>

                <div class="my-4">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
            block w-full p-2.5 
            focus:border-green-500 focus:ring-green-500 
            required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
            valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                        required>
                        <option value="" disabled selected>Select a Category</option>
                        <option value="incoming">Incoming</option>
                        <option value="outgoing">Outgoing</option>
                    </select>
                </div>

                <div class="my-4">
                    <label for="classification"
                        class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                    <select id="classification" name="classification"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
            block w-full p-2.5 
            focus:border-green-500 focus:ring-green-500 
            required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
            valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                        required>
                        <option value="" disabled selected>Select a Classification</option>
                        <option value="highly-technical">Highly Technical</option>
                        <option value="simple">Simple</option>
                    </select>
                </div>

                <div class="my-4">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
            block w-full p-2.5 
            focus:border-green-500 focus:ring-green-500 
            required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
            valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                        required>
                        <option value="" disabled selected>Select a Status</option>
                        <option value="received">Received</option>
                        <option value="outgoing">Outgoing</option>
                    </select>
                </div>
                <input type="hidden" id="permit_type" value="{{ $type }}" name="permit-type">
                @if (!isset($category))
                    <input type="hidden" id="land_category" value="" name="land_category">
                @else
                    <input type="hidden" id="land_category" value="{{ $category }}" name="land_category">
                @endif
                <input type="hidden" id="municipality" value="{{ $municipality }}" name="municipality">
                <div class="flex justify-end gap-4">

                    {{-- <button type="button" id="next-step"
                        class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                        Next
                    </button> --}}

                </div>
            </div>

            <!-- step 2 -->
            <div class="font-medium">

                @if ($type == 'tree-cutting-permits')
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Value" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid name for the client!
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="species" class="block mb-2 text-sm font-medium text-gray-700">Species</label>
                        <input type="text" id="species" name="species"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Value" required>
                        <p id="species-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid species!
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="no-of-tree-species" class="block mb-2 text-sm font-medium text-gray-700">No. of
                            Trees</label>
                        <input type="number" id="no-of-tree-species" name="no_of_tree_species"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter number of trees" required>
                        <p id="no-of-tree-species-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid number of trees and species.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Value" required>
                        <p id="location-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid location.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="date-applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date-applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                        <p id="date-applied-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid date.
                        </p>
                    </div>
                @elseif ($type == 'tree-plantation')
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Value" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the name of the client.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="number_of_trees" class="block mb-2 text-sm font-medium text-gray-700">No. of Trees
                            Planted</label>
                        <input type="number" id="number_of_trees" name="number_of_trees"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter number of trees" required>
                        <p id="number_of_trees-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid number of trees.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Value" required>
                        <p id="location-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid location.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="date-applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date-applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                        <p id="date-applied-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid date.
                        </p>
                    </div>
                @elseif ($type == 'tree-transport-permits')
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Client's Name" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the name of the client.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="species" class="block mb-2 text-sm font-medium text-gray-700">Species</label>
                        <input type="text" id="species" name="species"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Species" required>
                        <p id="species-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid species.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="number-of-trees" class="block mb-2 text-sm font-medium text-gray-700">Number of
                            Trees</label>
                        <input type="number" id="number-of-trees" name="number_of_trees"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Number of Trees" required>
                        <p id="number-of-trees-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the number of trees.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="destination"
                            class="block mb-2 text-sm font-medium text-gray-700">Destination</label>
                        <input type="text" id="destination" name="destination"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Destination" required>
                        <p id="destination-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid destination.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="date-applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date-applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                        <p id="date-applied-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid date.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="date-of-transport" class="block mb-2 text-sm font-medium text-gray-700">Date of
                            Transport</label>
                        <input type="date" id="date-of-transport" name="date_of_transport"
                            class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                        <p id="date-of-transport-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid date for transport.
                        </p>
                    </div>
                @elseif ($type == 'chainsaw-registration')
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Client's Name" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the name of the client.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Location" required>
                        <p id="location-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid location.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="serial-number" class="block mb-2 text-sm font-medium text-gray-700">Serial
                            Number</label>
                        <input type="text" id="serial-number" name="serial_number"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Serial Number" required>
                        <p id="serial-number-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the serial number.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="date-applied" class="block mb-2 text-sm font-medium text-gray-700">Date
                            Applied</label>
                        <input type="date" id="date-applied" name="date_applied"
                            class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                        <p id="date-applied-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid date.
                        </p>
                    </div>
                @elseif ($type == 'land-titles')
                    <div class="my-4">
                        <label for="name-of-client" class="block mb-2 text-sm font-medium text-gray-700">Name of
                            Client</label>
                        <input type="text" id="name-of-client" name="name_of_client"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Client's Name" required>
                        <p id="name-of-client-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the name of the client.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" name="location"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Location" required>
                        <p id="location-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter a valid location.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="lot-number" class="block mb-2 text-sm font-medium text-gray-700">Lot
                            Number</label>
                        <input type="text" id="lot-number" name="lot_number"
                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                      block w-full p-2.5 
                      focus:border-green-500 focus:ring-green-500 
                      required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                      valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            placeholder="Enter Lot Number" required>
                        <p id="lot-number-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Enter the lot number.
                        </p>
                    </div>

                    <div class="my-4">
                        <label for="property-category" class="block mb-2 text-sm font-medium text-gray-700">Property
                            Category</label>
                        <select id="property-category" name="property_category"
                            class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg block w-full p-2.5 
                       focus:border-green-500 focus:ring-green-500 
                       required:border-red-500 required:ring-red-500 required:text-red-500 required:placeholder:text-red-500
                       valid:border-green-500 valid:ring-green-500 valid:text-green-500"
                            required>
                            <option value="" disabled selected>Select Property Category</option>
                            <option value="residential">Residential</option>
                            <option value="agricultural">Agricultural</option>
                            <option value="special">Special</option>
                        </select>
                        <p id="property-category-error" class="mt-2 text-sm text-red-600 hidden">
                            <span class="font-medium">Please!</span> Select a property category.
                        </p>
                    </div>
                @endif

            </div>
            <div class="mt-4 flex justify-end gap-4 col-span-2">
                {{-- <button type="button" id="back"
                    class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                    Back
                </button> --}}
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
