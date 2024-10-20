<div id="upload-file-div" class="">
    <form id="upload-form" enctype="multipart/form-data">
        @csrf
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold">Upload File</h2> {{-- add summary --}}

        </div>
        <div class="" id="step-1">


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

            <div class="flex my-2">
                <label for="office-source" class="text-black mt-2 mr-4 w-1/6">Office Source:</label>
                <div class="w-full">
                    <input type="text" id="office-source" placeholder="Enter Value"
                        class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                    <!-- Ensure the error message doesn't shift other elements -->
                    <p id="office-source-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                        Please enter an Office Source.</p>
                </div>
            </div>

            <div class="flex  my-2">
                <label for="category" class="text-black mr-4 w-1/6">Category:</label>
                <div class="w-full">
                    <select id="category" class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <option value="" disabled selected>Select a Category</option>
                        <option value="incoming">Incoming</option>
                        <option value="outgoing">Outgoing</option>

                    </select>
                </div>

            </div>

            <div class="flex items-center my-4">
                <label for="classification" class="text-black mr-4 w-1/6">Classification:</label>
                <div class="w-full">
                    <select id="classification" class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <option value="" disabled selected>Select a Classification</option>
                        <option value="highly-technical">Highly Technical</option>
                        <option value="simple">Simple</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center my-4">
                <label for="status" class="text-black mr-4 w-1/6">Status:</label>
                <div class="w-full">
                    <select id="status" class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <option value="" disabled selected>Select a Status</option>
                        <option value="recieved">Recieved</option>
                        <option value="outgoing">Outgoing</option>

                    </select>
                </div>
            </div>

            <input type="hidden" id="permit_type" value="{{ $type }}" name="permit-type">
            @if (!isset($category))
                <input type="hidden" id="land_category" value="" name="land_category">
            @else
                <input type="hidden" id="land_category" value="{{ $category }}" name="land_category">
            @endif
            <input type="hidden" id="municipality" value="{{ $municipality }}" name="municipality">




            <div class="flex justify-end gap-4">

                <button type="button" id="next-step"
                    class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                    Next
                </button>

            </div>
        </div>

        <div class="hidden" id="step-2">


            <p id="file-upload-name2" class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                No file chosen
            </p>

            @if ($type == 'tree-cutting-permits')
                <div class="flex mt-4">
                    <label for="name-of-client" class=" text-black mt-2 mr-4 w-1/6">Name
                        of Client
                    </label>
                    <div class="w-full">
                        <input type="text" id="name-of-client" placeholder="Enter Value"
                            class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="name-of-client-error"
                            class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter an Name Client</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="no-of-tree-species" class="text-black mt-2 mr-4 w-1/6">No. of Tree
                        / Species</label>
                    <div class="w-full">
                        <input type="number" id="no-of-tree-species" placeholder="Enter number of trees / species"
                            class="no-of-tree-species border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="no-of-tree-species-error"
                            class="no-of-tree-species-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the number
                            of trees and species.</p>
                    </div>
                </div>



                <div class="flex mt-4">
                    <label for="location" class="text-black mt-2 mr-4 w-1/6">Location
                    </label>
                    <div class="w-full">
                        <input type="text" id="location" placeholder="Enter Value"
                            class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="location-error" class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter a Location</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                    <div class="w-full">
                        <input type="date" id="date-applied"
                            class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3 ">
                        <p id="date-applied-error"
                            class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Date Applied</p>
                    </div>
                </div>
            @elseif ($type == 'tree-plantation')
                <div class="flex mt-4">
                    <label for="name-of-client" class=" text-black mt-2 mr-4 w-1/6">Name
                        of
                        Client</label>
                    <div class="w-full">
                        <input type="text" id="name-of-client" placeholder="Enter Value"
                            class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="name-of-client-error"
                            class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Name of the Client</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="number_of_trees" class="text-black mt-2 mr-4 w-1/6">No. of Trees
                        Planted</label>
                    <div class="w-full">
                        <input type="number" id="number_of_trees" placeholder="Enter number of trees"
                            class="number_of_trees border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="number_of_trees-error"
                            class="number_of_trees-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the number
                            of trees.</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                    <div class="w-full">
                        <input type="text" id="location" placeholder="Enter Value"
                            class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="location-error" class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter a Location</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                    <div class="w-full">
                        <input type="date" id="date-applied"
                            class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="date-applied-error"
                            class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Date Applied</p>
                    </div>
                </div>
            @elseif ($type == 'tree-transport-permits')
                <div class="flex mt-4">
                    <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                        Client</label>
                    <div class="w-full">
                        <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                            class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="name-of-client-error"
                            class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Name of the Client</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="number-of-trees" class="text-black mt-2 mr-4 w-1/6">Number of
                        Trees</label>
                    <div class="w-full">
                        <input type="number" id="number-of-trees" placeholder="Enter Number of Trees"
                            class="number-of-trees border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="number-of-trees-error"
                            class="number-of-trees-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the number
                            of trees</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="destination" class="text-black mt-2 mr-4 w-1/6">Destination</label>
                    <div class="w-full">
                        <input type="text" id="destination" placeholder="Enter Destination"
                            class="destination border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="destination-error"
                            class="destination-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Destionation</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                    <div class="w-full">
                        <input type="date" id="date-applied"
                            class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="date-applied-error"
                            class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Date Applied</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="date-of-transport" class="text-black mt-2 mr-4 w-1/6">Date of
                        Transport</label>
                    <div class="w-full">
                        <input type="date" id="date-of-transport"
                            class="date-of-transport border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="date-of-transport-error"
                            class="date-of-transport-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Date of
                            Transport</p>
                    </div>
                </div>
            @elseif ($type == 'chainsaw-registration')
                <div class="flex mt-4">
                    <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                        Client</label>
                    <div class="w-full">
                        <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                            class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="name-of-client-error"
                            class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Name of the Client</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                    <div class="w-full">
                        <input type="text" id="location" placeholder="Enter Location"
                            class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="location-error" class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter a Location</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="serial-number" class="text-black mt-2 mr-4 w-1/6">Serial
                        Number</label>
                    <div class="w-full">
                        <input type="text" id="serial-number" placeholder="Enter Serial Number"
                            class="serial-number border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="serial-number-error"
                            class="serial-number-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Serial
                            Number</p>
                    </div>
                </div>

                <div class="flex mt-4">
                    <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                    <div class="w-full">
                        <input type="date" id="date-applied"
                            class="date-applied border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="date-applied-error"
                            class="date-applied-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Date Applied</p>
                    </div>
                </div>
            @elseif ($type == 'land-titles')
                <div class="flex mt-4">
                    <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                        Client</label>
                    <div class="w-full">
                        <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                            class="name-of-client border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="name-of-client-error"
                            class="name-of-client-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Name of the Client</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                    <div class="w-full">
                        <input type="text" id="location" placeholder="Enter Location"
                            class="location border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="location-error" class="location-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter a Location</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="lot-number" class="text-black mt-2 mr-4 w-1/6">Lot Number</label>
                    <div class="w-full">
                        <input type="text" id="lot-number" placeholder="Enter Lot Number"
                            class="lot-number border border-gray-300 p-2 rounded-md h-10 w-2/3">
                        <p id="lot-number-error" class="lot-number-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please enter the Lot Number</p>
                    </div>
                </div>

                <div class="flex mt-2">
                    <label for="property-category" class="text-black mt-2 mr-4 w-1/6">Property
                        Category</label>
                    <div class="w-full">
                        <select id="property-category"
                            class="property-category border border-gray-300 p-2 rounded-md h-10 w-2/3">
                            <option value="" disabled selected>Select Property Category</option>
                            <option value="residential">Residential</option>
                            <option value="agricultural">Agricultural</option>
                            <option value="special">Special</option>
                        </select>
                        <p id="property-category-error"
                            class="property-category-error text-red-500 ml-2 min-h-[1.5rem] invisible">
                            Please select a Property
                            Category</p>
                    </div>
                </div>
            @endif

            <div class="mt-4 flex justify-end gap-4">

                <button type="button" id="back"
                    class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                    Back
                </button>


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

        <p id="error-message" class="mt-2 text-red-500 hidden"></p>
        <p id="success-message" class="mt-2 text-green-500 hidden"></p>
    </form>

</div>
