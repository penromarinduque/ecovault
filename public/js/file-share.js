//file share modal 
async function fileShare(fileId) {
    const fileShareModal = document.getElementById('file-share-modal');

    try {
        const response = await fetch(`/api/files/${fileId}?includePermit=true`);

        // Check if the response is ok (status in the range 200-299)
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        if (data && data.file) {
            document.getElementById('share-file-name').textContent = data.file.file_name;
            document.getElementById('file_id').value = fileId;
            // Set shareFileId to the fileId instead of using .value


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
        return;
    }

    console.log(JSON.stringify(formDataObj, null, 2));
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
        } else {
            alert('Failed to share file: ' + data.message);
        }


    } catch (error) {
        console.error('Error sharing file:', error);
        alert('An error occurred while sharing the file.');
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





