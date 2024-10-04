@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-300 h-[600px] rounded-md text-black p-4">
        <nav aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <li><span class=""> File Manager </span></li>
                <li><span class="text-gray-400"> &gt; </span></li>
                <li><a>{{ ucwords(str_replace('-', ' ', $type)) }}</a></li>
                @if (isset($category))
                    <li><span class="text-gray-400"> &gt; </span></li>
                    <li><a>{{ ucwords(str_replace('-', ' ', $category)) }}</a></li>
                @endif
                <li><span class="text-gray-400"> &gt; </span></li>
                <li><a class="">Municipality</a></li>
                <li><span class="text-gray-400"> &gt; </span></li>
                <li><a class="font-bold">{{ $municipality }}</a></li>
            </ol>
        </nav>

        <div class="flex justify-end items-center">
            <div class="relative">
                <input type="text" class="placeholder:px-4 pl-2 py-1 rounded-md border border-gray-300"
                    placeholder="Quick Search">
                <i class='bx bx-search absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
            </div>
        </div>

        <div class="my-4 space-x-3">
            <button class="bg-white px-2 p-1 rounded-md" id="uploadBtn">Upload File</button>
            <button class="bg-white px-2 p-1 rounded-md">Create a Folder</button>
            <button class="bg-white px-2 p-1 rounded-md">Sort By</button>
            <button class="bg-white px-2 p-1 rounded-md">View</button>
        </div>


        <div class="relative">
            <div id="mainTable" class=" transition-opacity duration-500 ease-in-out opacity-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-t border-black">
                        <thead>
                            <tr class="text-sm leading-normal">
                                <th class="py-3 px-6 border-b border-black text-left">Name</th>
                                <th class="py-3 px-6 border-b border-black text-left">Date Modified</th>
                                <th class="py-3 px-6 border-b border-black text-left">Modified By</th>
                                <th class="py-3 px-6 border-b border-black text-left">Category</th>
                                <th class="py-3 px-6 border-b border-black text-left">Classification</th>
                                <th class="py-3 px-6 border-b border-black text-left">Status</th>
                                <th class="py-3 px-6 border-b border-black text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-black hover:bg-gray-100">
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 1</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 2</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 3</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 4</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 5</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 6</td>
                                <td class="py-3 px-6 border-b border-black">Row 1, Col 7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="uploadFileSection"
                class="absolute inset-0 transition-opacity duration-500 ease-in-out opacity-0 pointer-events-none">
                <div class="flex  gap-4">
                    <div class="overflow-x-auto w-5/12 gap-4 ">
                        <table class="min-w-full border-t border-black">
                            <thead>
                                <tr class="text-sm leading-normal">
                                    <th class="py-3 px-6 border-b border-black text-left">Name</th>
                                    <th class="py-3 px-6 border-b border-black text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <tr class="border-b border-black">
                                    <td class="py-3 px-6 border-b border-black">File 1.zip</td>
                                    <td class="py-3 px-6 border-b border-black">
                                        <button class="text-black"><i class='bx bx-dots-vertical-rounded'></i></button>
                                    </td>
                                </tr>
                                <tr class="border-b border-black">
                                    <td class="py-3 px-6 border-b border-black">File 2</td>
                                    <td class="py-3 px-6 border-b border-black">
                                        <button class="text-black"><i class='bx bx-dots-vertical-rounded'></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="w-full p-4 bg-white rounded-md ">


                        <form id="upload-form" enctype="multipart/form-data">
                            @csrf

                            <div class="" id="step-1">

                                <div class="flex justify-between items-center mb-2 ">
                                    <h2 class="text-lg font-bold">Upload File</h2>
                                    <button type="button" id="close-upload-section"
                                        class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                                        <i class='bx bx-x bx-md'></i>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <label class="block mt-2">
                                        <input type="file" name="file" class="hidden" id="file-upload">
                                        <span
                                            class="inline-block bg-green-500 text-white rounded-md px-8 py-2 cursor-pointer hover:bg-green-600 transition duration-200">
                                            <i class='bx bx-cloud-upload'></i> Choose File
                                        </span>
                                    </label>

                                    <p id="file-upload-name"
                                        class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
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
                                        <select id="classification"
                                            class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
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

                                <div class="flex justify-end gap-4">

                                    <button type="button" id="next-step"
                                        class="bg-green-500 text-white rounded-md px-8 py-2 hover:bg-green-600 transition duration-200">
                                        Next
                                    </button>

                                </div>
                            </div>

                            <div class="hidden" id="step-2">
                                <div class="flex justify-between items-center mb-2 ">
                                    <h2 class="text-lg font-bold">Upload File <span class="font-normal"> - File
                                            Summary</span></h2>
                                    <button type="button" id="close-upload-section"
                                        class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                                        <i class='bx bx-x bx-md'></i>
                                    </button>
                                </div>

                                <p id="file-upload-name2"
                                    class="mt-2 inline-block bg-green-500 text-white rounded-md px-8 py-2">
                                    No file chosen
                                </p>

                                @if ($type == 'tree-cutting-permits')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of Client
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Value"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter an Name Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="no-of-tree-species" class="text-black mt-2 mr-4 w-1/6">No. of Tree
                                            / Species</label>
                                        <div class="w-full">
                                            <input type="number" id="no-of-tree-species"
                                                placeholder="Enter number of trees / species"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="no-of-tree-species-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please enter the number
                                                of trees and species.</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Value"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Location
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="date-applied" placeholder="Enter Value"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'tree-plantation')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Value"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="no-of-trees-planted" class="text-black mt-2 mr-4 w-1/6">No. of Trees
                                            Planted</label>
                                        <div class="w-full">
                                            <input type="number" id="no-of-trees-planted"
                                                placeholder="Enter number of trees planted"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="no-of-trees-planted-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please enter the number
                                                of trees planted.</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Value"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-planted" class="text-black mt-2 mr-4 w-1/6">Date Planted</label>
                                        <div class="w-full">
                                            <input type="date" id="date-planted" placeholder="Enter Date Planted"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-planted-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the date of planting</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'tree-transport-permits')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="number-of-trees" class="text-black mt-2 mr-4 w-1/6">Number of
                                            Trees</label>
                                        <div class="w-full">
                                            <input type="number" id="number-of-trees"
                                                placeholder="Enter Number of Trees"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="number-of-trees-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please enter the number
                                                of trees</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-of-transport" class="text-black mt-2 mr-4 w-1/6">Date of
                                            Transport</label>
                                        <div class="w-full">
                                            <input type="date" id="date-of-transport"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-of-transport-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please enter the Date of
                                                Transport</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'chainsaw-registration')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Location"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="serial-number" class="text-black mt-2 mr-4 w-1/6">Serial
                                            Number</label>
                                        <div class="w-full">
                                            <input type="text" id="serial-number" placeholder="Enter Serial Number"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="serial-number-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please enter the Serial
                                                Number</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-4">
                                        <label for="date-applied" class="text-black mt-2 mr-4 w-1/6">Date Applied</label>
                                        <div class="w-full">
                                            <input type="date" id="date-applied"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="date-applied-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Date Applied</p>
                                        </div>
                                    </div>
                                @elseif ($type == 'land-titles')
                                    <div class="flex mt-4">
                                        <label for="name-of-client" class="text-black mt-2 mr-4 w-1/6">Name of
                                            Client</label>
                                        <div class="w-full">
                                            <input type="text" id="name-of-client" placeholder="Enter Client's Name"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="name-of-client-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Name of the Client</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="location" class="text-black mt-2 mr-4 w-1/6">Location</label>
                                        <div class="w-full">
                                            <input type="text" id="location" placeholder="Enter Location"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="location-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter a Location</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="lot-number" class="text-black mt-2 mr-4 w-1/6">Lot Number</label>
                                        <div class="w-full">
                                            <input type="text" id="lot-number" placeholder="Enter Lot Number"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                            <p id="lot-number-error" class="text-red-500 ml-2 min-h-[1.5rem] invisible">
                                                Please enter the Lot Number</p>
                                        </div>
                                    </div>

                                    <div class="flex mt-2">
                                        <label for="property-category" class="text-black mt-2 mr-4 w-1/6">Property
                                            Category</label>
                                        <div class="w-full">
                                            <select id="property-category"
                                                class="border border-gray-300 p-2 rounded-md h-10 w-2/3">
                                                <option value="" disabled selected>Select Property Category</option>
                                                <option value="residential">Residential</option>
                                                <option value="agricultural">Agricultural</option>
                                                <option value="special">Special</option>
                                            </select>
                                            <p id="property-category-error"
                                                class="text-red-500 ml-2 min-h-[1.5rem] invisible">Please select a Property
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
                                        <span id="button-text">Upload</span>
                                    </button>
                                </div>
                            </div>

                            <p id="error-message" class="mt-2 text-red-500 hidden"></p>
                            <p id="success-message" class="mt-2 text-green-500 hidden"></p>
                        </form>

                        <div id="toast"
                            class="hidden fixed z-[90] right-0 bottom-0 m-8 bg-red-500 text-white p-4 rounded-lg shadow-lg transition-opacity duration-300 ">
                            <div class="flex justify-between items-center">
                                <p id="toast-message" class="mr-4"></p>
                                <button id="toast-close" class="text-white focus:outline-none hover:text-gray-200">
                                    <i class='bx bx-x bx-md'></i>
                                </button>
                            </div>
                            <div id="toast-timer" class="w-full h-1 bg-green-300 mt-2"></div>
                        </div>

                    </div>

                    <script>
                        const fileInput = document.getElementById('file-upload');
                        const fileUploadName = document.getElementById('file-upload-name');
                        const fileUploadNameStep2 = document.getElementById('file-upload-name2');


                        document.getElementById('next-step').addEventListener('click', function() {
                            let isValid = true;
                            if (fileInput.files.length === 0) {

                                const fileUploadError = document.getElementById('file-upload-error');
                                fileUploadError.classList.remove('invisible');
                                return;
                            }


                            const officeSourceInput = document.getElementById('office-source');
                            const officeSourceError = document.getElementById('office-source-error');


                            const categorySelect = document.getElementById('category');
                            const classificationSelect = document.getElementById('classification');
                            const statusSelect = document.getElementById('status');



                            officeSourceInput.classList.remove('border-red-500');
                            officeSourceError.classList.add('invisible');
                            categorySelect.classList.remove('border-red-500');
                            classificationSelect.classList.remove('border-red-500');
                            statusSelect.classList.remove('border-red-500');

                            if (officeSourceInput.value.trim() === '') {
                                officeSourceInput.classList.add('border-red-500');
                                officeSourceError.classList.remove('invisible'); // Show error message
                                isValid = false;
                            }

                            // Validate 'Category' select
                            if (categorySelect.value === '') {
                                categorySelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Validate 'Classification' select
                            if (classificationSelect.value === '') {
                                classificationSelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Validate 'Status' select
                            if (statusSelect.value === '') {
                                statusSelect.classList.add('border-red-500');
                                isValid = false;
                            }

                            // Only move to step 2 if all fields are valid
                            if (isValid) {
                                document.getElementById('step-1').classList.add('hidden');
                                document.getElementById('step-2').classList.remove('hidden');

                                const selectedFile = fileInput.files[0]; // Get the selected file
                                fileUploadNameStep2.textContent = `File: ${selectedFile.name}`;
                            }
                        });

                        document.getElementById('office-source').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                            document.getElementById('office-source-error').classList.add('invisible');

                        })


                        document.getElementById('category').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                            this.classList.add('text-black')

                        });

                        document.getElementById('classification').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                        });

                        document.getElementById('status').addEventListener('change', function() {
                            this.classList.remove('border-red-500');
                        });

                        document.getElementById('back').addEventListener('click', function() {

                            document.getElementById('step-1').classList.remove('hidden');
                            document.getElementById('step-2')
                                .classList.add('hidden');
                        })


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






                        function showToast(message, isSuccess) {
                            const toast = document.getElementById('toast');
                            const toastMessage = document.getElementById('toast-message');
                            const toastClose = document.getElementById('toast-close');
                            const toastTimer = document.getElementById('toast-timer');

                            toastMessage.textContent = message;
                            toast.classList.remove('hidden');


                            if (isSuccess) {
                                toast.classList.add('bg-green-500');
                                toast.classList.remove('bg-red-500');
                                toastTimer.classList.remove('bg-red-300');
                                toastTimer.classList.add('bg-green-300');
                            } else {
                                toast.classList.add('bg-red-500');
                                toast.classList.remove('bg-green-500');
                                toastTimer.classList.remove('bg-green-300');
                                toastTimer.classList.add('bg-red-300');
                            }

                            let timerDuration = 3000;
                            let timerWidth = 100;


                            toastTimer.style.width = '100%';


                            const timerInterval = setInterval(() => {
                                timerWidth -= (100 / (timerDuration / 100));
                                toastTimer.style.width = `${timerWidth}%`;
                            }, 100);


                            setTimeout(() => {
                                clearInterval(timerInterval);
                                toast.classList.add('hidden');
                            }, timerDuration);


                            toastClose.onclick = function() {
                                clearInterval(timerInterval);
                                toast.classList.add('hidden');
                            };
                        }



                        document.getElementById('upload-form').addEventListener('submit', function(e) {
                            e.preventDefault();

                            const submitButton = document.getElementById('upload-btn');
                            const buttonText = document.getElementById('button-text');
                            const buttonSpinner = document.getElementById('button-spinner');

                            submitButton.disabled = true;
                            buttonText.classList.add('hidden'); // Hide the button text
                            buttonSpinner.classList.remove('hidden');

                            const formData = new FormData(this);
                            const csrfToken = document.querySelector('input[name="_token"]').value;

                            const officeSource = document.getElementById('office-source').value;
                            const category = document.getElementById('category').value;
                            const classification = document.getElementById('classification').value;
                            const status = document.getElementById('status').value;

                            formData.append('office-source', officeSource);
                            formData.append('category', category);
                            formData.append('classification', classification);
                            formData.append('status', status);

                            //const fileId = null
                            fetch("{{ route('file.post') }}", {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {

                                    if (data.success) {

                                        showToast(data.message, true);
                                        // console.log(data.data)

                                        //if $type treecuting

                                        //fetch for tree cutting
                                        //const FileId = 1;
                                        //  fetch()

                                        // Reset form fields
                                        this.reset();

                                        // Clear file upload display names
                                        const fileInput = document.getElementById('file-upload');
                                        const fileUploadName = document.getElementById('file-upload-name');
                                        const fileUploadNameStep2 = document.getElementById('file-upload-name2');

                                        // Clear file input (this.reset() should handle it, but manually if needed)

                                        // Reset the file name displays
                                        fileUploadName.textContent = 'No file chosen';
                                        fileUploadNameStep2.textContent = 'No file chosen';
                                    } else {
                                        console.log(data);
                                        showToast(data.message || 'File upload failed.', false);
                                    }
                                })
                                .catch(error => {
                                    console.log(error);
                                    showToast('An error occurred while uploading the file.', false);
                                }).finally(() => {

                                    //add post here
                                    //id file

                                    // Re-enable the button and revert to the original state
                                    submitButton.disabled = false;
                                    buttonText.classList.remove('hidden'); // Show the button text again
                                    buttonSpinner.classList.add('hidden'); // Hide the spinner

                                });
                        });
                    </script>
                </div>
            </div>
        </div>


    </div>

    <script>
        document.getElementById('uploadBtn').addEventListener('click', function() {
            const mainTable = document.getElementById('mainTable');
            const uploadFileSection = document.getElementById('uploadFileSection');


            mainTable.classList.remove('opacity-100');
            mainTable.classList.add('opacity-0');


            setTimeout(() => {
                mainTable.classList.add('pointer-events-none');
                uploadFileSection.classList.remove('opacity-0', 'pointer-events-none');
                uploadFileSection.classList.add('opacity-100');
            }, 300);
        });

        document.getElementById('close-upload-section').addEventListener('click', function() {
            const mainTable = document.getElementById('mainTable');
            const uploadFileSection = document.getElementById('uploadFileSection');

            // Fade out the upload section
            uploadFileSection.classList.remove('opacity-100');
            uploadFileSection.classList.add('opacity-0');

            setTimeout(() => {
                // Disable pointer events on upload section
                uploadFileSection.classList.add('pointer-events-none');
                // Enable interactions on the main table
                mainTable.classList.remove('pointer-events-none'); // Enable interactions on main table
                // Make the main table visible
                mainTable.classList.remove('opacity-0'); // Ensure opacity is set back to fully visible
                mainTable.classList.add('opacity-100'); // Make main table fully visible
            }, 300); // Match this to your CSS transition duration
        });
    </script>

@endsection
