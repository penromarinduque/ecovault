@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <h1>PENRO Archiving System Backup and Restore</h1>

    <form id="restoreForm">
        @csrf
        <label for="backupSelect">Select Backup to Restore:</label>
        <select id="backupSelect" class="p-2 border-2 border-black">
            <option value="" disabled selected>Select a backup file</option>
            {{-- Populate with available backup files from the server --}}
        </select>
        <button id="recover" class="p-4 border-2 border-black mt-2" onclick="RecoverFiles()">Restore Selected Backup</button>
    </form>

    <button id="backup" class="p-4 border-2 border-black mt-4" onclick="BackupFiles()">Create New Backup</button>

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
            fetch('/api/files/backup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.success || data.error);
                    fetchBackupFiles(); // Refresh backup list after creating a new backup
                })
                .catch(error => {
                    console.error('Backup failed:', error);
                });
        }

        function RecoverFiles() {
            const selectedFile = document.getElementById('backupSelect').value;
            if (!selectedFile) {
                alert('Please select a backup file to restore.');
                return;
            }

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
                    alert(data.success || data.error);
                })
                .catch(error => {
                    console.error('Recovery failed:', error);
                });
        }
    </script>
@endsection
