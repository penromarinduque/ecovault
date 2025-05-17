@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-4">

        <div class="bg-white shadow-md rounded-lg p-4">
            <img src="{{ asset('images/reports/ltp.png') }}" alt="Local Transport Permit" class="w-20">

            <h3 class="text-lg font-semibold mb-4">Total Number of Transport Permits Issued</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="transportDestinationFilter"
                        class="block text-sm font-medium text-gray-700">Destination:</label>
                    <select id="transportDestinationFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="All">All</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <script>
                    // Populate destination dropdown from /api/ltp/destination
                    document.addEventListener('DOMContentLoaded', async () => {
                        try {
                            const response = await fetch('/api/ltp/destination');
                            const destinations = await response.json();
                            const select = document.getElementById('transportDestinationFilter');
                            destinations.forEach(dest => {
                                const option = document.createElement('option');
                                option.value = dest;
                                option.textContent = dest;
                                select.appendChild(option);
                            });
                        } catch (e) {
                            console.error('Error fetching destinations:', e);
                        }
                    });
                </script>
                <div>
                    <label for="transportTimeframeFilter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
                    <select id="transportTimeframeFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>

                <div>
                    <label for="transportstartDateFilter" class="block text-sm font-medium text-gray-700">Start
                        Date:</label>
                    <input type="date" id="transportstartDateFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div>
                    <label for="transportendDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
                    <input type="date" id="transportendDateFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <button id="applyTransportFilters"
                    class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Apply Filters
                </button>
            </div>
            <div id="transportPermitsChart"></div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Total Number of Species Transported</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="speciesDestinationFilter"
                        class="block text-sm font-medium text-gray-700">Destination:</label>
                    <select id="speciesDestinationFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="All">All</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <script>
                    // Populate destination dropdown for species chart from /api/ltp/destination
                    document.addEventListener('DOMContentLoaded', async () => {
                        try {
                            const response = await fetch('/api/ltp/destination');
                            const destinations = await response.json();
                            const select = document.getElementById('speciesDestinationFilter');
                            destinations.forEach(dest => {
                                const option = document.createElement('option');
                                option.value = dest;
                                option.textContent = dest;
                                select.appendChild(option);
                            });
                        } catch (e) {
                            console.error('Error fetching destinations:', e);
                        }
                    });
                </script>
                <div>
                    <label for="speciesFilter" class="block text-sm font-medium text-gray-700">Species:</label>
                    <select id="speciesFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="All">All</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <div>
                    <label for="startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
                    <input type="date" id="startDateFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <div>
                    <label for="endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
                    <input type="date" id="endDateFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>
                <button id="applyFilters"
                    class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Apply Filters
                </button>
            </div>
            <div id="speciesTransportedChart"></div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Total Number of Business Owners with Local Transport Permits</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="businessDestinationFilter"
                        class="block text-sm font-medium text-gray-700">Destination:</label>
                    <select id="businessDestinationFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="All">All</option>
                        <!-- Options will be dynamically populated -->
                    </select>
                </div>
                <script>
                    // Populate destination dropdown for business owners chart from /api/ltp/destination
                    document.addEventListener('DOMContentLoaded', async () => {
                        try {
                            const response = await fetch('/api/ltp/destination');
                            const destinations = await response.json();
                            const select = document.getElementById('businessDestinationFilter');
                            destinations.forEach(dest => {
                                const option = document.createElement('option');
                                option.value = dest;
                                option.textContent = dest;
                                select.appendChild(option);
                            });
                        } catch (e) {
                            console.error('Error fetching destinations:', e);
                        }
                    });
                </script>
                <div>
                    <label for="businessTimeframeFilter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
                    <select id="businessTimeframeFilter"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <button id="applyBusinessFilters"
                    class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Apply Filters
                </button>
            </div>
            <div id="businessOwnersChart"></div>
        </div>
    </div>

    <script>
        let speciesChart, transportChart, businessChart; // Declare chart instances globally

        async function fetchSpeciesOptions() {
            try {
                const response = await fetch('/api/butterfly-species');
                const species = await response.json();
                const speciesFilter = document.getElementById("speciesFilter");

                species.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.common_name;
                    option.textContent = item.common_name;
                    speciesFilter.appendChild(option);
                });
            } catch (error) {
                console.error("Error fetching species:", error);
            }
        }

        // Fetch and render Species Transported Chart
        function fetchSpeciesTransportedChart() {
            const species = document.getElementById('speciesFilter').value || 'All';
            // const municipality = document.getElementById('municipalityFilter').value || 'All';
            const startDate = document.getElementById('startDateFilter').value;
            const endDate = document.getElementById('endDateFilter').value;
            const des = document.getElementById('speciesDestinationFilter').value || 'All';
            const url = new URL('/api/species-transported-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', 'monthly');
            if (species !== 'All') url.searchParams.append('species', species);
            // if (municipality !== 'All') url.searchParams.append('municipality', municipality);
            if (startDate) url.searchParams.append('start_date', startDate);
            if (endDate) url.searchParams.append('end_date', endDate);
            if (des !== 'All') url.searchParams.append('destination', des);
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data || data.length === 0) {
                        document.getElementById('speciesTransportedChart').innerHTML =
                            '<p class="text-center text-gray-500">No data available for the selected filters.</p>';
                        return;
                    }

                    const categories = [...new Set(data.map(item => item.month && item.year ?
                        `${item.month} ${item.year}` : item.year))];
                    const speciesGroups = [...new Set(data.map(item => item.species))];
                    const series = speciesGroups.map(speciesName => ({
                        name: speciesName,
                        data: categories.map(category => {
                            const entry = data.find(item => (item.month && item.year ?
                                    `${item.month} ${item.year}` : item.year) === category &&
                                item.species === speciesName);
                            return entry ? entry.total_species : 0;
                        })
                    }));

                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350,
                            stacked: true
                        },
                        colors: ['#1A56DB', '#E91E63', '#FFC107', '#4CAF50', '#9C27B0'], // Custom colors
                        series: series,
                        xaxis: {
                            categories: categories,
                            title: {
                                text: 'Timeframe'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Number of Species Transported'
                            },
                            labels: {
                                formatter: function(value) {
                                    return Math.round(value); // Ensure solid numbers
                                }
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '70%',
                                borderRadius: 8
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        legend: {
                            position: 'top'
                        }
                    };

                    // Destroy existing chart instance if it exists
                    if (speciesChart) {
                        speciesChart.destroy();
                    }

                    // Create a new chart instance
                    speciesChart = new ApexCharts(document.querySelector("#speciesTransportedChart"), options);
                    speciesChart.render();
                })
                .catch(error => {
                    console.error('Error fetching species data:', error);
                });
        }

        // Fetch and render Transport Permits Chart
        function fetchTransportPermitsChart() {
            // const municipality = document.getElementById('transportMunicipalityFilter').value || 'All';
            const timeframe = document.getElementById('transportTimeframeFilter').value || 'monthly';
            const startDate = document.getElementById('transportstartDateFilter').value;
            const endDate = document.getElementById('transportendDateFilter').value;
            const des = document.getElementById('transportDestinationFilter').value || 'All';
            const url = new URL('/api/transport-permits-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', timeframe);
            if (startDate) url.searchParams.append('start_date', startDate);
            if (endDate) url.searchParams.append('end_date', endDate);
            if (des !== 'All') url.searchParams.append('destination', des);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        colors: ['#1E90FF'], // Custom color for this chart (Dodger Blue)
                        series: [{
                            name: 'Total Permits',
                            data: data.map(item => item.total_permits)
                        }],
                        xaxis: {
                            categories: data.map(item => timeframe === 'yearly' ? item.year :
                                `${item.month} ${item.year}`)
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return Math.round(value); // Ensure solid numbers
                                }
                            }
                        }
                    };

                    // Destroy existing chart instance if it exists
                    if (transportChart) {
                        transportChart.destroy();
                    }

                    // Create a new chart instance
                    transportChart = new ApexCharts(document.querySelector("#transportPermitsChart"), options);
                    transportChart.render();
                })
                .catch(error => {
                    console.error('Error fetching transport permits data:', error);
                });
        }

        // Fetch and render Business Owners Chart
        function fetchBusinessOwnersChart() {
            // const municipality = document.getElementById('businessMunicipalityFilter').value || 'All';
            const timeframe = document.getElementById('businessTimeframeFilter').value || 'monthly';
            const des = document.getElementById('businessDestinationFilter').value || 'All';
            const url = new URL('/api/business-owners-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', timeframe);
            if (des !== 'All') url.searchParams.append('destination', des);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        colors: ['#32CD32'], // Custom color for this chart (Lime Green)
                        series: [{
                            name: 'Total Business Owners',
                            data: data.map(item => item.total_business_owners)
                        }],
                        xaxis: {
                            categories: data.map(item => timeframe === 'yearly' ? item.year :
                                `${item.month} ${item.year}`)
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return Math.round(value); // Ensure solid numbers
                                }
                            }
                        }
                    };

                    // Destroy existing chart instance if it exists
                    if (businessChart) {
                        businessChart.destroy();
                    }

                    // Create a new chart instance
                    businessChart = new ApexCharts(document.querySelector("#businessOwnersChart"), options);
                    businessChart.render();
                })
                .catch(error => {
                    console.error('Error fetching business owners data:', error);
                });
        }

        // Load default charts and populate species dropdown on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetchSpeciesOptions(); // Populate species dropdown
            fetchSpeciesTransportedChart();
            fetchTransportPermitsChart();
            fetchBusinessOwnersChart();
        });

        // Apply filters when the buttons are clicked
        document.getElementById('applyFilters').addEventListener('click', fetchSpeciesTransportedChart);
        document.getElementById('applyTransportFilters').addEventListener('click', fetchTransportPermitsChart);
        document.getElementById('applyBusinessFilters').addEventListener('click', fetchBusinessOwnersChart);
    </script>
@endsection
