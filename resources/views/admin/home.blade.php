@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="bg-gray-400 h-[600px] rounded-md text-black p-4">
        <h2 class="text-lg font-bold mb-4">Storage Usage</h2>
        <canvas id="storageChart" width="400" height="400"></canvas>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('admin.storage.usage') }}")
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('storageChart').getContext('2d');

                    const chart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['PENRO Directory', 'Other Usage', 'Free Space'],
                            datasets: [{
                                data: [data.penro_space, data.other_space, data.free_space],
                                backgroundColor: ['#FF6384', '#36A2EB', '#4BC0C0'],
                                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#4BC0C0']
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            let label = tooltipItem.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += Math.round(tooltipItem.raw * 100) / 100 +
                                                ' GB';
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
        });
    </script>


    <script>
        // Fetch recent uploads on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchRecentUploads();
        });

        function fetchRecentUploads() {
            fetch('/recent-uploads')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    displayRecentUploads(data.data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function displayRecentUploads(uploads) {
            const tableBody = document.getElementById('recent-uploads-body');
            tableBody.innerHTML = ''; // Clear existing content

            uploads.forEach(upload => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${upload.user}</td>
                    <td>${upload.action}</td>
                    <td>${upload.subject_type}</td>
                    <td>${upload.subject_id}</td>
                    <td>${upload.timestamp}</td>
                `;
                tableBody.appendChild(row);
            });
        }
    </script>
    </head>

    <body>
        <h1>Recent Uploads</h1>

        <table border="1">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Subject Type</th>
                    <th>Subject ID</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody id="recent-uploads-body">
                <!-- Recent uploads will be inserted here -->
            </tbody>
        </table>
    @endsection
