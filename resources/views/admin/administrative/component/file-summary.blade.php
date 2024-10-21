<div id="upload-file" class="">
    <div class="flex justify-between items-center mb-2">
        <h2 class="text-lg font-bold">File Summary</h2> {{-- add summary --}}
        <button type="button" id="close-upload-btn"
            class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
            <i class='bx bx-x bx-md'></i>
        </button>
    </div>

    <div class="flex space-x-4">
        <div class="flex-1">
            <div>
                <label for="office_source" class="block mb-2 text-sm font-medium text-gray-700">Office
                    Source</label>
                <input type="text" id="office_source" name="office_source"
                    class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-red-500 required:ring-red-500  required:text-red-500 required:placeholder:text-red-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-500 "
                    placeholder="Enter office Source" required>

                <p class="mt-2 text-sm text-red-600 h-6 invisible"><span class="font-medium">Please!</span> Enter
                    valid input!</p>
            </div>
            <!-- Category Field -->
            <div>
                <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                <select id="category" name="category"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg valid:ring-green-500 valid:border-green-500 block w-full p-2.5 required:border-red-500 required:ring-red-500 required:text-red-500 valid:text-gray-900 "
                    required>
                    <option value="">Select a Category</option>
                    <option value="incoming">Incoming</option>
                    <option value="outgoing">Outgoing</option>
                    <!-- Add more categories as needed -->
                </select>
                <p class="mt-2 text-sm text-red-600 h-6 invisible"><span class="font-medium">Please!</span> Enter
                    valid
                    input!
                </p>
            </div>

            <!-- Classification Field -->
            <div>
                <label for="classification" class="block mb-2 text-sm font-medium text-gray-700">Classification</label>
                <select id="classification" name="classification"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg valid:ring-green-500 valid:border-green-500 block w-full p-2.5 required:border-red-500 required:ring-red-500 required:text-red-500 valid:text-gray-900 "
                    required>
                    <option value="">Select Classification</option> <!-- Default empty option -->
                    <option value="high-technical">High Technical</option>
                    <option value="simple">Simple</option>
                </select>
                <p class="mt-2 text-sm text-red-600 h-6 invisible"><span class="font-medium">Please!</span> Select a
                    valid classification.</p>
            </div>

            <!-- Status Field -->
            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                    class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded-lg valid:ring-green-500 valid:border-green-500 block w-full p-2.5 required:border-red-500 required:ring-red-500 required:text-red-500 valid:text-gray-900 "
                    required>
                    <option value="">Select Status</option> <!-- Default empty option -->
                    <option value="received">Received</option>
                    <option value="outgoing">Outgoing</option>
                </select>
                <p class="mt-2 text-sm text-red-600 h-6 invisible"><span class="font-medium">Please!</span> Select a
                    valid status.</p>
            </div>

        </div>

    </div>

    <div class="flex justify-end">
        <button id="submit-button" type="submit"
            class="py-2.5 px-5 me-2 text-sm font-medium text-white bg-green-500 rounded-lg border border-green-200 
            hover:bg-green-600 hover:text-white focus:z-10 focus:ring-4 focus:outline-none 
            focus:ring-green-700 inline-flex items-center disabled:bg-green-300 disabled:text-gray-500 disabled:border-green-300">
            <svg id="loading-icon" aria-hidden="true" role="status"
                class="inline w-4 h-4 me-3 text-gray-200 animate-spin hidden" viewBox="0 0 100 101" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="#1C64F2" />
            </svg>
            <span id="button-text">Submit</span>
        </button>
    </div>



</div>
