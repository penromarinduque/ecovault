@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-4">
        <x-chart.local-transport-permit />
        <div>
            <h3>Total Number of Transport Permits Issued</h3>
            <div id="transportPermitsChart"></div>
        </div>
        <div>
            <h3>Total Number of Species Transported</h3>
            <div>
                <label for="municipalityFilter">Municipality:</label>
                <select id="municipalityFilter">
                    <option value="All">All</option>
                    <option value="Gasan">Gasan</option>
                    <option value="Boac">Boac</option>
                    <option value="Buenavista">Buenavista</option>
                    <option value="Torijos">Torijos</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                </select>

                <label for="speciesFilter">Species:</label>
                <input type="text" id="speciesFilter" placeholder="All">

                <label for="startDateFilter">Start Date:</label>
                <input type="date" id="startDateFilter">

                <label for="endDateFilter">End Date:</label>
                <input type="date" id="endDateFilter">

                <button id="applyFilters">Apply Filters</button>
            </div>
            <div id="speciesTransportedChart"></div>
        </div>
        <div>
            <h3>Total Number of Business Owners with Local Transport Permits</h3>
            <div id="businessOwnersChart"></div>
        </div>
    </div>

    <script>
        let speciesChart; // Declare chart instance globally

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
                            categories: data.map(item => item.municipality ? `${item.municipality} (${item.species})` : item.species)
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

        // Load default chart on page load
        document.addEventListener('DOMContentLoaded', fetchSpeciesTransportedChart);

        // Apply filters when the button is clicked
        document.getElementById('applyFilters').addEventListener('click', fetchSpeciesTransportedChart);

        // Fetch and render Transport Permits Chart
        fetch('/api/transport-permits-by-municipality?timeframe=monthly')
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
                        categories: data.map(item => item.month || item.year)
                    }
                };
                const chart = new ApexCharts(document.querySelector("#transportPermitsChart"), options);
                chart.render();
            });

        // Fetch and render Business Owners Chart
        fetch('/api/business-owners-by-municipality?timeframe=monthly')
            .then(response => response.json())
            .then(data => {
                const options = {
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    series: data.map(item => item.total_business_owners),
                    labels: data.map(item => item.municipality)
                };
                const chart = new ApexCharts(document.querySelector("#businessOwnersChart"), options);
                chart.render();
            });
    </script>
@endsection
