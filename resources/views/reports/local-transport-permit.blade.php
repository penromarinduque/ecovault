@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-4">
        <x-chart.local-transport-permit />
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Total Number of Transport Permits Issued</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="transportMunicipalityFilter" class="block text-sm font-medium text-gray-700">Municipality:</label>
                    <select id="transportMunicipalityFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="All">All</option>
                        <option value="Gasan">Gasan</option>
                        <option value="Boac">Boac</option>
                        <option value="Buenavista">Buenavista</option>
                        <option value="Torijos">Torijos</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                    </select>
                </div>
                <div>
                    <label for="transportTimeframeFilter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
                    <select id="transportTimeframeFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <button id="applyTransportFilters" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
            </div>
            <div id="transportPermitsChart"></div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Total Number of Species Transported</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="municipalityFilter" class="block text-sm font-medium text-gray-700">Municipality:</label>
                    <select id="municipalityFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="All">All</option>
                        <option value="Gasan">Gasan</option>
                        <option value="Boac">Boac</option>
                        <option value="Buenavista">Buenavista</option>
                        <option value="Torijos">Torijos</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                    </select>
                </div>
                <div>
                    <label for="speciesFilter" class="block text-sm font-medium text-gray-700">Species:</label>
                    <input type="text" id="speciesFilter" placeholder="All" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
                    <input type="date" id="startDateFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
                    <input type="date" id="endDateFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button id="applyFilters" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
            </div>
            <div id="speciesTransportedChart"></div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Total Number of Business Owners with Local Transport Permits</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div>
                    <label for="businessMunicipalityFilter" class="block text-sm font-medium text-gray-700">Municipality:</label>
                    <select id="businessMunicipalityFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="All">All</option>
                        <option value="Gasan">Gasan</option>
                        <option value="Boac">Boac</option>
                        <option value="Buenavista">Buenavista</option>
                        <option value="Torijos">Torijos</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                    </select>
                </div>
                <div>
                    <label for="businessTimeframeFilter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
                    <select id="businessTimeframeFilter" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                </div>
                <button id="applyBusinessFilters" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Apply Filters
                </button>
            </div>
            <div id="businessOwnersChart"></div>
        </div>
    </div>

    <script>
        let speciesChart, transportChart, businessChart; // Declare chart instances globally

        // Fetch and render Species Transported Chart
        function fetchSpeciesTransportedChart() {
            const species = document.getElementById('speciesFilter').value || 'All';
            const municipality = document.getElementById('municipalityFilter').value || 'All';
            const startDate = document.getElementById('startDateFilter').value;
            const endDate = document.getElementById('endDateFilter').value;

            const url = new URL('/api/species-transported-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', 'monthly');
            if (species !== 'All') url.searchParams.append('species', species);
            if (municipality !== 'All') url.searchParams.append('municipality', municipality);
            if (startDate) url.searchParams.append('start_date', startDate);
            if (endDate) url.searchParams.append('end_date', endDate);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Total Species',
                            data: data.map(item => item.total_species)
                        }],
                        xaxis: {
                            categories: data.map(item => item.month && item.year ? `${item.month} ${item.year}` : item.species)
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
            const municipality = document.getElementById('transportMunicipalityFilter').value || 'All';
            const timeframe = document.getElementById('transportTimeframeFilter').value || 'monthly';

            const url = new URL('/api/transport-permits-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', timeframe);
            if (municipality !== 'All') url.searchParams.append('municipality', municipality);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Total Permits',
                            data: data.map(item => item.total_permits)
                        }],
                        xaxis: {
                            categories: data.map(item => item.month && item.year ? `${item.month} ${item.year}` : item.year)
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
            const municipality = document.getElementById('businessMunicipalityFilter').value || 'All';
            const timeframe = document.getElementById('businessTimeframeFilter').value || 'monthly';

            const url = new URL('/api/business-owners-by-municipality', window.location.origin);
            url.searchParams.append('timeframe', timeframe);
            if (municipality !== 'All') url.searchParams.append('municipality', municipality);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Total Business Owners',
                            data: data.map(item => item.total_business_owners)
                        }],
                        xaxis: {
                            categories: data.map(item => item.month && item.year ? `${item.month} ${item.year}` : item.year)
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

        // Load default charts on page load
        document.addEventListener('DOMContentLoaded', () => {
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
