@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <h1>File Sharing</h1>

    <!-- File Sharing Form -->
    <h2>Share File</h2>
    <form id="fileShareForm">
        @csrf
        <label for="file_id">File ID:</label>
        <input type="text" id="file_id" name="file_id" required placeholder="Enter file ID" />

        <label for="shared_with_user_id">Select User:</label>
        <select id="shared_with_user_id" name="shared_with_user_id" required>
            <option value="" disabled selected>Select a user</option>
        </select>


        <label for="permission">Permissions:</label>
        <select id="permission" name="permission" required>
            <option value="" disabled selected>Select permissions</option>
            <option value="viewer">Viewer</option>
            <option value="editor">Editor</option>
            {{-- <option value="admin">Admin</option> --}}
        </select>



        <button type="submit">Share File</button>
    </form>

    <h1>File List</h1>
    <table id="files-table">
        <thead>
            <tr class="mx-4">
                <th>ID</th>
                <th>File Name</th>
                <th>Updated At</th>
                <th>Office Source</th>
                <th>User Name</th>
                <th>Category</th>
                <th>Classification</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be inserted here -->
        </tbody>
    </table>

    <script>
        async function loadFiles() {
            try {
                const response = await fetch('/api/files?report=memoranda');
                if (!response.ok) throw new Error('Failed to fetch files');
                const data = await response.json();
                if (!data.success) {
                    console.error('Error:', data.message);
                    alert(data.message);
                    return;
                }

                const tableBody = document.getElementById('files-table').querySelector('tbody');
                tableBody.innerHTML = ''; // Clear previous data

                data.files.forEach(file => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="mx-4">${file.id}</td>
                        <td class="mx-4">${file.file_name}</td>
                        <td class="mx-4">${file.updated_at}</td>
                        <td class="mx-4">${file.office_source}</td>
                        <td class="mx-4">${file.user_name}</td>
                        <td class="mx-4">${file.category}</td>
                        <td class="mx-4">${file.classification}</td>
                        <td class="mx-4">${file.status}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } catch (error) {
                console.error('Error loading files:', error);
                alert('An error occurred while loading files.');
            }
        }

        async function fetchEmployees() {
            try {
                const response = await fetch('/api/users');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                if (data.success) {
                    const users = data.employees; // Assuming the API returns employee list in employees key
                    const userSelect = document.getElementById('shared_with_user_id');

                    users.forEach(employee => {
                        const option = document.createElement('option');
                        option.value = employee.id;
                        option.textContent = employee.name; // Display employee name
                        userSelect.appendChild(option);
                    });
                } else {
                    console.error('Failed to retrieve employees:', data.message);
                }
            } catch (error) {
                console.error('Error fetching employees:', error);
            }
        }

        // Share file function
        document.getElementById('fileShareForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);
            const csrfToken = formData.get('_token');
            const formDataObj = Object.fromEntries(formData.entries());

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
                    alert('File shared successfully!');
                    event.target.reset(); // Reset the form after submission
                } else {
                    alert('Failed to share file: ' + data.message);
                }
            } catch (error) {
                console.error('Error sharing file:', error);
                alert('An error occurred while sharing the file.');
            }
        });

        // Load files and employees when the page loads
        window.addEventListener('load', () => {
            loadFiles();
            fetchEmployees();
        });
    </script>

@endsection
