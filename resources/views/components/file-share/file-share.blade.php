<!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
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

                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label for="category"
                                        class="block mb-2 text-md font-medium text-gray-900">Due</label>
                                    <div class="relative pb-0">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 " xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 20 20">
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
                                    placeholder=""></textarea>
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
<script>
    //file share modal 
    // document.addEventListener('click', (event) => {
    //     // Check if the clicked element has the class 'share-file-link'
    //     if (event.target.matches('.share-file-link')) {
    //         event.preventDefault(); // Prevent default link behavior
    //         const fileId = event.target.dataset.fileId;
    //         fileShare(fileId); // Call the async function with the fileId
    //     }
    // });

    async function fileShare(fileId) {

        const includePermit = @json($includePermit);
        console.log(includePermit);
        const fileShareModal = document.getElementById('file-share-modal');

        try {
            // Use the dynamically set `includePermit` value directly in the URL
            const response = await fetch(`/api/files/${fileId}?includePermit=${includePermit}`);

            // Check if the response is ok (status in the range 200-299)
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            if (data && data.file) {
                document.getElementById('share-file-name').textContent = truncateFilename(data.file.file_name, 20);
                document.getElementById('file_id').value = fileId;
                fileShareModal.classList.remove('hidden');
            } else {
                console.error('Invalid data structure:', data);
            }
        } catch (error) {
            console.error('Error fetching file name:', error);
        }
    }


    document.getElementById('file-share-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const csrfToken = formData.get('_token');
        const formDataObj = Object.fromEntries(formData.entries());

        const sharedWithUserId = formData.get('shared_with_user_id');

        if (!sharedWithUserId) {
            showToast({
                type: 'danger',
                message: 'Could not be share to unregister user.',

            });
            return;
        }

        try {
            const response = await fetch('/api/files/share', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Set CSRF token in the headers
                },
                body: formData,

            });

            const data = await response.json();
            if (data.success) {
                event.target.reset();
                clearSelection();
                closeFileShare();
                showToast({
                    type: 'success',
                    message: data.message,

                });
            } else {
                showToast({
                    type: '',
                    message: data.message,

                });
            }


        } catch (error) {
            console.error('Error sharing file:', error);
            showToast({
                type: 'danger',
                message: 'An error occurred while sharing the file.',

            });

        }
    });

    // file share
    // DOM Elements
    const fileShareModal = document.getElementById('file-share-modal');
    const userList = document.getElementById('user-list');
    const searchDropdown = document.getElementById('search-dropdown');
    const searchInput = document.getElementById('user-search');
    const selectedEmployeePill = document.getElementById('selected-employee-pill');
    const selectedEmployeeName = document.getElementById('selected-employee-name');
    const clearSelectionButton = document.getElementById('clear-selection');
    const closeModalButton = fileShareModal.querySelector('button[type="button"]');
    const selectedEmployeeIdInput = document.getElementById('shared_with_user_id');

    // Fetch Controller and Selection State
    let fetchController = null;
    let selectedEmployee = null;

    // Function to close the file-sharing modal
    function closeFileShare() {
        fileShareModal.classList.add('hidden');
    }

    // Function to display employees in the dropdown list
    function displayEmployees(employees) {
        userList.innerHTML = ''; // Clear previous results

        if (employees.length > 0) {
            searchDropdown.classList.remove('hidden'); // Show dropdown
            employees.forEach(employee => {
                const listItem = document.createElement('li');
                listItem.classList.add('cursor-pointer', 'hover:bg-gray-200', 'p-2');
                listItem.innerHTML = `
                <div class="text-sm text-gray-900">
                    <div class="font-medium">${employee.name}</div>
                    <div class="truncate">${employee.email}</div>
                </div>
            `;
                listItem.addEventListener('click', () => selectEmployee(employee)); // Attach selection handler
                userList.appendChild(listItem); // Append to list
            });
        } else {
            searchDropdown.classList.add('hidden'); // Hide dropdown if no results
        }
    }

    // Function to handle search input and fetch filtered employees
    function filterEmployees() {
        const searchTerm = searchInput.value.trim().toLowerCase();

        // Hide dropdown and abort request if input is empty
        if (searchTerm === '') {
            userList.innerHTML = '';
            searchDropdown.classList.add('hidden');
            if (fetchController) fetchController.abort();
            return;
        }

        fetchEmployees(searchTerm); // Start fetching with the search term
    }

    // Function to fetch employees based on search term from the API
    async function fetchEmployees(searchTerm) {
        if (fetchController) fetchController.abort(); // Abort previous fetch
        fetchController = new AbortController();

        try {
            const response = await fetch(`/api/users?search=${encodeURIComponent(searchTerm)}`, {
                signal: fetchController.signal
            });
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();

            // Display employees only if input still matches searchTerm
            if (searchInput.value.trim().toLowerCase() === searchTerm && data.success) {
                displayEmployees(data.employees);
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Error fetching employees:', error);
            }
        }
    }

    // Function to handle employee selection
    function selectEmployee(employee) {
        selectedEmployeeIdInput.value = employee.id; // Set ID in hidden input
        selectedEmployee = employee; // Save selected employee object
        selectedEmployeeName.textContent = employee.name; // Display name in pill
        selectedEmployeePill.classList.remove('hidden'); // Show the pill
        searchInput.classList.add('hidden'); // Hide the search input
        searchDropdown.classList.add('hidden'); // Hide the dropdown
    }

    // Function to clear the selected employee from input
    function clearSelection() {
        selectedEmployee = null; // Clear selected employee
        selectedEmployeePill.classList.add('hidden'); // Hide the pill
        searchInput.classList.remove('hidden'); // Show input for new search
        searchInput.value = ''; // Clear input field
        searchInput.focus(); // Refocus for further searching
        selectedEmployeeIdInput.value = ''; // Clear hidden input value
    }

    // Attach event listeners
    searchInput.addEventListener('input', filterEmployees);
    clearSelectionButton.addEventListener('click', clearSelection);
    closeModalButton.addEventListener('click', closeFileShare);
</script>
