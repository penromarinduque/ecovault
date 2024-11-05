<div id="file-share-modal" class="hidden">
    <div class=" fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div id="usersContainer"></div>
        <div class="relative p-4 w-full max-w-md">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Share "<span id="share-file-name"></span>"
                    </h3>
                    <button type="button"
                        class="p-3 rounded-full text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-md h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4">
                    <form id="file-share-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="file_id" id="file_id" value="" />
                        <input type="hidden" name="shared_with_user_id" id="shared_with_user_id" value="" />
                        <div class="space-y-4">

                            <div class="relative">
                                <h1 class="block mb-2 text-md font-medium text-gray-900">Select Employee</h1>

                                <!-- Input Container for search and selected employee pill -->
                                <div class="relative">
                                    <!-- Input Container without border and focus styles -->
                                    <div id="input-container"
                                        class="flex border border-gray-500 items-center h-14 rounded-md w-full">

                                        <!-- Selected Employee Pill -->
                                        <span id="selected-employee-pill"
                                            class="hidden flex items-center bg-blue-100 text-blue-700 rounded-full px-2 py-1 mx-2 text-md font-medium">
                                            <span id="selected-employee-name"></span>
                                            <button id="clear-selection" class="ml-4 text-red-500 text-lg">✕</button>
                                        </span>
                                        <!-- Input Field with Border and Focus Styles -->
                                        <input type="text" id="user-search"
                                            class="bg-transparent h-full  border-0 text-gray-900 rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full"
                                            placeholder="Search for employees" autocomplete="off" />
                                    </div>

                                    <!-- Dropdown for displaying employee search results -->
                                    <div id="search-dropdown"
                                        class="z-20 mt-1 hidden absolute bg-gray-50 rounded-md shadow-xl border border-gray-500 w-full">
                                        <ul id="user-list" class="pt-2 pb-2 text-md text-gray-700">
                                            <!-- Display employees here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label for="permission"
                                        class="block mb-2 text-md font-medium text-gray-900">Permission</label>
                                    <select id="permission" name="permission"
                                        class="border border-gray-500 text-gray-900 text-md rounded-md fous:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                        <option disabled selected class="">Select permissions</option>
                                        <option value="viewer">Viewer</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="category"
                                        class="block mb-2 text-md font-medium text-gray-900">Due</label>
                                    <div class="relative pb-0">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="datepicker-format" datepicker datepicker-format="mm-dd-yyyy"
                                            autocomplete="off" name="expiration_date" type="text"
                                            class=" border border-gray-500 text-gray-900 text-md rounded-md fous:ring-primary-500 focus:border-primary-500 w-full ps-10 p-2.5"
                                            placeholder="Select date">
                                    </div>
                                </div>

                            </div>
                            <!-- text area-->
                            <div class="relative">
                                <textarea type="text" id="remarks" name="remarks"
                                    class="resize-none block px-2.5 pb-2.5 pt-4 w-full text-gray-900 bg-transparent rounded-md border-1 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" "></textarea>
                                <label for="remarks"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-1 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Message
                                </label>
                            </div>



                            <button type="submit"
                                class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-md text-md px-5 py-2.5 text-center">Share</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
