@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
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
                    ShowAlert(data.success);
                    fetchBackupFiles(); // Refresh backup list after creating a new backup
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
@endsection
