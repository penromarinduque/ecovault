@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-gray-400 h-[600px] rounded-md text-black p-4">
        <h2 class="text-lg font-bold mb-4">Storage Usage</h2>
        <canvas id="storageChart" width="400" height="400"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
@endsection
