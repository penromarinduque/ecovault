// file share modal 
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


            fileShareModal.classList.remove('hidden');
        } else {
            console.error('Invalid data structure:', data);

        }
    } catch (error) {
        console.error('Error fetching file name:', error);

    }

}

// file share
const fileShareModal = document.getElementById('file-share-modal');
const userList = document.getElementById('user-list');
const searchDropdown = document.getElementById('search-dropdown');
const searchInput = document.getElementById('user-search');
const selectedEmployeePill = document.getElementById('selected-employee-pill');
const selectedEmployeeName = document.getElementById('selected-employee-name');
const clearSelectionButton = document.getElementById('clear-selection');
const closeModalButton = fileShareModal.querySelector('button[type="button"]');

// Create an AbortController for fetch requests
let fetchController = null;
let selectedEmployee = null;
// Function to close the file sharing modal
function closeFileShare() {
    fileShareModal.classList.add('hidden');
}

// Function to display employees in the dropdown list
function displayEmployees(employees) {
    userList.innerHTML = '';

    if (employees.length > 0) {
        searchDropdown.classList.remove('hidden');
        employees.forEach(employee => {
            const listItem = document.createElement('li');
            listItem.classList.add('cursor-pointer', 'hover:bg-gray-200', 'p-2');
            listItem.innerHTML = `
                <div class=" text-sm text-gray-900">
                    <div class="font-medium">${employee.name}</div>
                    <div class="truncate">${employee.email}</div>
                </div>
            `;
            
            // Event listener for selecting an employee
            listItem.addEventListener('click', () => selectEmployee(employee));
            userList.appendChild(listItem);
        });
    } else {
        searchDropdown.classList.add('hidden');
    }
}

// Function to handle search input and fetch filtered employees
function filterEmployees() {
    const searchTerm = searchInput.value.trim().toLowerCase();

    if (searchTerm === '') {
        userList.innerHTML = '';
        searchDropdown.classList.add('hidden');
        // Abort any ongoing request if the input is empty
        if (fetchController) fetchController.abort();
        return;
    }

    // Start fetching with the search term
    fetchEmployees(searchTerm);
}

// Fetch employees based on search term from the API
async function fetchEmployees(searchTerm) {
    // Abort any ongoing fetch if a new one starts
    if (fetchController) fetchController.abort();
    fetchController = new AbortController();

    try {
        const response = await fetch(`/api/users?search=${encodeURIComponent(searchTerm)}`, {
            signal: fetchController.signal
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();

        // Check if input is still valid before displaying results
        if (searchInput.value.trim().toLowerCase() === searchTerm && data.success) {
            displayEmployees(data.employees);
        }

    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Error fetching employees:', error);
        }
    }
}

function selectEmployee(employee) {
    selectedEmployee = employee; // Save selected employee
    selectedEmployeeName.textContent = employee.name; // Set name in pill
    selectedEmployeePill.classList.remove('hidden'); // Show pill
    searchInput.classList.add('hidden'); // Hide the input
    searchDropdown.classList.add('hidden'); // Hide dropdown
}

// Function to clear the selected employee from input
function clearSelection() {
    selectedEmployee = null; // Reset selected employee
    selectedEmployeePill.classList.add('hidden'); // Hide pill
    searchInput.classList.remove('hidden'); // Show input
    searchInput.value = ''; // Clear input field
    searchInput.focus(); // Focus back on input for a new search
}

// Attach event listeners
searchInput.addEventListener('input', filterEmployees);
clearSelectionButton.addEventListener('click', clearSelection);
closeModalButton.addEventListener('click', closeFileShare);





