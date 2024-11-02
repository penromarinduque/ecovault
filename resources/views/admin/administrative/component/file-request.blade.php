<div id="file-request"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 rounded-t ">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Request Access
                </h3>
                <button id="close-file-request-btn" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="file-request-form">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">File
                            Name</label>
                        <input type="text" name="name" id="file-request_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="" disabled>

                    </div>

                    <div class="col-span-2">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 ">Category</label>
                        <select id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Select permission</option>
                            <option value="viewer">Viewer</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>

                    <div class="col-span-2">
                        <label for="remarks" class="block mb-2 text-sm font-medium text-gray-900 ">Remarks</label>
                        <textarea id="remarks" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 "
                            placeholder="Write remarks here" required></textarea>
                    </div>

                    <input type="hidden" id="request-file-id">
                    <input type="hidden" id="request-user-id" value="{{ auth()->user()->id }}">
                </div>
                <button type="submit"
                    class="text-white w-full items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Request for Access
                </button>
            </form>
        </div>
    </div>
</div>
