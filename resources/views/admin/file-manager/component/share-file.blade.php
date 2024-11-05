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
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-8" action="#">

                        <div class="relative">
                            <h1 class="block mb-2 text-md font-medium text-gray-900">Select Employee</h1>

                            <!-- Input Container for search and selected employee pill -->
                            <div class="relative">
                                <!-- Input Container without border and focus styles -->
                                <div id="input-container"
                                    class="flex border border-gray-500 bg-gray-50 items-center h-14 rounded-md w-full">

                                    <!-- Selected Employee Pill -->
                                    <span id="selected-employee-pill"
                                        class="hidden flex items-center bg-blue-100 text-blue-700 rounded-full px-2 py-1 mx-2 text-md font-medium">
                                        <span id="selected-employee-name"></span>
                                        <button id="clear-selection" class="ml-4 text-red-500 text-lg">✕</button>
                                    </span>

                                    <!-- Input Field with Border and Focus Styles -->
                                    <input type="text" id="user-search"
                                        class="bg-transparent h-full  border-0 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full"
                                        placeholder="Search for employees" autocomplete="off" />
                                </div>

                                <!-- Dropdown for displaying employee search results -->
                                <div id="search-dropdown"
                                    class="z-10 mt-1 hidden absolute bg-gray-50 rounded-lg shadow-xl border border-gray-300 w-full">
                                    <ul id="user-list" class="pt-2 pb-2 text-md text-gray-700">
                                        <!-- Display employees here -->
                                    </ul>
                                </div>
                            </div>


                        </div>

                        {{-- <div>
                        <label for="category" class="block mb-2 text-md font-medium text-gray-900">Permission</label>
                        <select id="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg fous:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option disabled selected>Select permissions</option>
                            <option value="viewer">Viewer</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div> --}}

                        <button type="submit"
                            class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-md px-5 py-2.5 text-center">Share</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
