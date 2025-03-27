@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <!-- Tab Navigation -->
    <div class="md:flex">
        <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
            <li>
                <a onclick="showTab(event, 'account')"
                    class="tab-btn active-tab inline-flex items-center px-4 py-3 text-white bg-blue-700 rounded-lg w-full dark:bg-blue-600"
                    aria-current="page">
                    <svg class="w-4 h-4 me-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                    </svg>
                    Profile
                </a>
            </li>
            <li>
                <a onclick="showTab(event, 'config')"
                    class="tab-btn inline-flex items-center px-4 py-3 rounded-lg
                   hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700
                   dark:hover:text-white">
                    <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                    </svg>
                    System Configuration
                </a>
            </li>
            <li>
                <a onclick="showTab(event, 'backup')"
                    class="tab-btn inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z" />
                    </svg>
                    Backup And Recovery
                </a>
            </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content w-full">
            <div id="account"
                class="tab-panel p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Profile Tab</h3>
                <form>
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" class="input-field" placeholder="Enter username">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" class="input-field" placeholder="Enter email">
                    </div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>

            <div id="config"
                class="tab-panel hidden p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">System Configuration</h3>

                <form id="configForm" class="max-w-sm ">
                    <!-- CSRF Token -->
                    @csrf

                    <div class="mb-5">
                        <label for="Drive"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Drive</label>
                        <input type="text" id="Drive" name="Drive"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Drive" required />
                    </div>
                    <div class="mb-5">
                        <label for="BackDirSQL"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">BackDirSQL</label>
                        <input type="text" id="BackDirSQL" name="BackDirSQL"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Back Directory SQL" required />
                    </div>
                    <div class="mb-5">
                        <label for="BackDirFiles"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">BackDirFiles</label>
                        <input type="text" id="BackDirFiles" name="BackDirFiles"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Back Directory Files" required />
                    </div>
                    <div class="mb-5">
                        <label for="StorePath"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">StorePath</label>
                        <input type="text" id="StorePath" name="StorePath"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Store Path" required />
                    </div>
                    <div class="mb-5">
                        <label for="MySqlDir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MySQL
                            Directory</label>
                        <input type="text" id="MySqlDir" name="MySqlDir"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="MySQL Directory" required />
                    </div>
                    <div class="mb-5">
                        <label for="MySqlDumpDir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MySQL
                            Dump Directory</label>
                        <input type="text" id="MySqlDumpDir" name="MySqlDumpDir"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="MySQL Dump Directory" required />
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
                <script>
                    // Listen for form submit

                    document.addEventListener('DOMContentLoaded', async () => {
                        try {
                            // Get the config data from the backend
                            const response = await fetch('/api/getconfig');

                            if (!response.ok) {
                                throw new Error('Failed to fetch config data');
                            }

                            const config = await response.json();

                            // Populate form fields with the config data
                            document.getElementById('Drive').value = config.Drive || ''; // Ensure it sets the value
                            document.getElementById('BackDirSQL').value = config.BackDirSQL || '';
                            document.getElementById('BackDirFiles').value = config.BackDirFiles || '';
                            document.getElementById('StorePath').value = config.StorePath || '';
                            document.getElementById('MySqlDir').value = config.MySqlDir || '';
                            document.getElementById('MySqlDumpDir').value = config.MySqlDumpDir || '';

                        } catch (error) {
                            console.error('Error fetching config:', error);

                        }
                    });
                    const form = document.getElementById('configForm');
                    form.addEventListener('submit', async (event) => {
                        event.preventDefault(); // Prevent default form submission

                        // Get form data
                        const formData = new FormData(form);

                        // Create an object to hold the form data
                        const data = {};
                        formData.forEach((value, key) => {
                            data[key] = value;
                        });

                        // Add CSRF token to data manually

                        const csrfToken = document.querySelector('input[name="_token"]').value;

                        try {
                            // Send the data using fetch
                            const response = await fetch('api/config', {
                                method: 'POST', // Use PUT for updating
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },


                                body: JSON.stringify(data),
                            });

                            const result = await response.json();

                            if (response.ok) {

                                fetchBackupFiles();

                            } else {

                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('An error occurred while updating the config.');
                        }
                    });
                </script>
            </div>

            <div id="backup"
                class="tab-panel hidden p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Backup And Recovery</h3>
                <div class="bg-white px-4">
                    <div class="space-y-6 max-w-lg">
                        <!-- Backup and Restore Form -->
                        <form id="restoreForm" class="space-y-4">
                            @csrf
                            <div>
                                <label for="backupSelect" class="block text-sm font-medium text-gray-700">Select Backup to
                                    Restore:</label>
                                <select id="backupSelect"
                                    class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled selected>Select a backup file</option>
                                    {{-- Populate with available backup files from the server --}}
                                </select>
                            </div>

                            <div class="flex justify-center">
                                <button id="recover" type="button" onclick="RecoverFiles()"
                                    class="w-full px-6 py-3 text-white bg-green-500 hover:bg-green-600 rounded-md shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">Restore
                                    Selected Backup</button>
                            </div>
                        </form>

                        <!-- Create Backup Button -->
                        <div class="flex justify-center">
                            <button id="backup" type="button" onclick="BackupFiles()"
                                class="w-full px-6 py-3 text-white bg-gray-600 hover:bg-gray-700 rounded-md shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-400">Create
                                New Backup</button>
                        </div>
                    </div>
                </div>

                <script>
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    // Fetch available backup files and populate the dropdown
                    function fetchBackupFiles() {
                        fetch('api/list-backups', {
                                method: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                const backupSelect = document.getElementById('backupSelect');
                                backupSelect.innerHTML =
                                    '<option value="" disabled selected>Select a backup file</option>'; // Reset dropdown

                                // Populate dropdown with backup files
                                data.files.forEach(file => {
                                    const option = document.createElement('option');
                                    option.value = file;
                                    option.textContent = file;
                                    backupSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Failed to fetch backup files:', error);
                            });
                    }

                    // Call fetchBackupFiles on page load to populate the dropdown
                    document.addEventListener('DOMContentLoaded', fetchBackupFiles);

                    function BackupFiles() {
                        const backupButton = document.getElementById('backup');
                        const recoverButton = document.getElementById('recover');

                        // Disable buttons
                        backupButton.disabled = true;
                        recoverButton.disabled = true;

                        fetch('/api/files/backup', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                showToast("data backup successfully");
                                fetchBackupFiles(); // Refresh backup list after creating a new backup

                            })
                            .catch(error => {
                                showToast(error, false);
                            })
                            .finally(() => {
                                // Re-enable buttons
                                backupButton.disabled = false;
                                recoverButton.disabled = false;
                            });
                    }

                    function RecoverFiles() {
                        const backupButton = document.getElementById('backup');
                        const recoverButton = document.getElementById('recover');

                        const selectedFile = document.getElementById('backupSelect').value;
                        if (!selectedFile) {
                            alert('Please select a backup file to restore.');
                            return;
                        }

                        // Disable buttons
                        backupButton.disabled = true;
                        recoverButton.disabled = true;

                        fetch('/api/files/restore', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    backup_file: selectedFile
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                ShowAlert(data.success);
                            })
                            .catch(error => {
                                ShowAlert(error, false);
                            })
                            .finally(() => {
                                // Re-enable buttons
                                backupButton.disabled = false;
                                recoverButton.disabled = false;
                            });
                    }
                </script>
            </div>
        </div>
    </div>

    <script>
        function showTab(event, tabId) {
            let tabs = document.querySelectorAll('.tab-panel');
            let tabButtons = document.querySelectorAll('.tab-btn');

            tabs.forEach(tab => tab.classList.add('hidden'));
            tabButtons.forEach(button => button.classList.remove('active-tab'));

            document.getElementById(tabId).classList.remove('hidden');
            event.currentTarget.classList.add('active-tab');
        }
    </script>
@endsection
