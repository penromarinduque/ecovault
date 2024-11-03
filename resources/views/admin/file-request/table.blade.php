@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">File Access Requests</h1>
        @csrf
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">File ID</th>
                    <th class="px-4 py-2 border-b">Requested By</th>
                    <th class="px-4 py-2 border-b">Handled By</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Requested Permission</th>
                    <th class="px-4 py-2 border-b">Remarks</th>
                    <th class="px-4 py-2 border-b">Created At</th>
                </tr>
            </thead>
            <tbody id="fileAccessRequestsTableBody">
                <!-- JavaScript will populate rows here -->
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch data from the API and populate the table
        async function fetchFileAccessRequests() {
            try {
                const response = await fetch('/api/files/GET/request-access');
                const data = await response.json();

                if (data.success) {
                    const requests = data.requests;
                    const tableBody = document.getElementById('fileAccessRequestsTableBody');
                    console.log(requests)
                    // Clear existing rows
                    tableBody.innerHTML = '';

                    // Loop through the requests and create table rows
                    requests.forEach(request => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                        <td class="px-4 py-2 border-b text-center">${request.id}</td>
                        <td class="px-4 py-2 border-b text-center">${request.file_id}</td>
                        <td class="px-4 py-2 border-b text-center">${request.requested_by ? request.requested_by.name : 'Unknown'}</td>
                        <td class="px-4 py-2 border-b text-center">${request.handled_by_admin_id ?? 'Not Handled'}</td>
                        <td class="px-4 py-2 border-b text-center">${request.status.charAt(0).toUpperCase() + request.status.slice(1)}</td>
                        <td class="px-4 py-2 border-b text-center">${request.requested_permission.charAt(0).toUpperCase() + request.requested_permission.slice(1)}</td>
                        <td class="px-4 py-2 border-b text-center">${request.remarks ?? 'N/A'}</td>
                        <td class="px-4 py-2 border-b text-center">${new Date(request.created_at).toLocaleString()}</td>
                          <td class="px-4 py-2 border-b text-center">
                                <button class="bg-green-500 text-white px-2 py-1 rounded" onclick="updateRequestStatus(${request.id}, 'approved')">Yes</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="updateRequestStatus(${request.id}, 'rejected')">No</button>
                            </td>                       
                    `;

                        tableBody.appendChild(row);
                    });
                } else {
                    console.error(data.message);
                }
            } catch (error) {
                console.error('Error fetching file access requests:', error);
            }
        }

        // Fetch data when the page loads
        document.addEventListener('DOMContentLoaded', fetchFileAccessRequests);

        async function updateRequestStatus(requestId, status) {
            const csrfToken = document.querySelector('input[name="_token"]').value;

            try {
                const response = await fetch(`/api/files/request-access/${requestId}?status=${status}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                });


                const data = await response.json();

                if (data.success) {
                    alert(data.message); // Display success message
                    fetchFileAccessRequests(); // Refresh the table
                } else {
                    console.error(data.message);
                }
            } catch (error) {
                console.error('Error updating request status:', error);
            }
        }
    </script>
@endsection
