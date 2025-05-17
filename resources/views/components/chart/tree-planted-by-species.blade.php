<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Trees Planted By Species</h3>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="species-location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="species-location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torrijos">Torrijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
            </select>
        </div>
        <div>
            <label for="species-timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="species-timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
      
        
        <div>
            <label for="species-filter" class="block text-sm font-medium text-gray-700">Species:</label>
            <select id="species-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="">All</option>
                <!-- Species options will be dynamically populated -->
            </select>
        </div>

        <div>
            <label for="species-startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="species-startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="species-endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="species-endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <button id="apply-species-filters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="species-chart"></div>
    <div id="no-data-message-trees" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <script>
        let species_chart;

        document.addEventListener("DOMContentLoaded", () => {
            initializeSpeciesChart();
            setupSpeciesEventListeners();
            fetchDistinctSpecies(); // Fetch distinct species
            fetchSpeciesChartData(); // Fetch initial data (monthly by default)
        });

        function initializeSpeciesChart() {
            const options = {
                chart: { type: "bar", height: 350, stacked: true },
                colors: ["#1A56DB", "#E91E63", "#FFC107", "#4CAF50", "#9C27B0"],
                series: [],
                xaxis: { categories: [] },
                yaxis: {
                    title: { text: "Number of Trees Planted" },
                    labels: { formatter: value => Math.round(value) }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } },
                dataLabels: { enabled: true },
                legend: { position: "top" }
            };

            species_chart = new ApexCharts(document.getElementById("species-chart"), options);
            species_chart.render();
        }

        function setupSpeciesEventListeners() {
            document.getElementById("apply-species-filters").addEventListener("click", () => {
                const location = document.getElementById("species-location-filter").value;
                const timeframe = document.getElementById("species-timeframe-filter").value;
                const species = document.getElementById("species-filter").value;
                const startDate = document.getElementById("species-startDateFilter").value;
                const endDate = document.getElementById("species-endDateFilter").value;
                fetchSpeciesChartData(location, timeframe, species, startDate, endDate);
            });
        }

        async function fetchDistinctSpecies() {
            try {
                const response = await fetch('/api/distinct-tree-species');
                if (!response.ok) throw new Error(`API call failed with status ${response.status}`);

                const species = await response.json();
                const speciesFilter = document.getElementById("species-filter");

                // Clear existing options
                speciesFilter.innerHTML = '<option value="">All</option>';

                // Populate dropdown with species
                species.forEach(speciesName => {
                    const option = document.createElement("option");
                    option.value = speciesName;
                    option.textContent = speciesName.charAt(0).toUpperCase() + speciesName.slice(1);
                    speciesFilter.appendChild(option);
                });
            } catch (error) {
                console.error("Error fetching distinct species:", error);
            }
        }

        async function fetchSpeciesChartData(location = "", timeframe = "monthly", species = "", startDate, endDate) {
            try {
                const url = new URL('/api/tree-plantation-statistics', window.location.origin);
                url.searchParams.append('municipality', location);
                url.searchParams.append('timeframe', timeframe);
                if (species) url.searchParams.append('species', species);
                if (startDate) url.searchParams.append('start_date', startDate);
                if (endDate) url.searchParams.append('end_date', endDate);

                const response = await fetch(url);
                if (!response.ok) throw new Error(`API call failed with status ${response.status}`);

                const { speciesData } = await response.json();
                updateSpeciesChart(speciesData, timeframe);
            } catch (error) {
                console.error("Error fetching species chart data:", error);
            }
               
        }

     function updateSpeciesChart(data, timeframe) {
    const noDataMessage = document.getElementById("no-data-message-trees");

    if (!data || Object.keys(data).length === 0) {
        noDataMessage.classList.remove("hidden");
        species_chart.updateSeries([]); // Clear existing series
        species_chart.updateOptions({
            xaxis: { categories: [] } // Clear categories if no data
        });
    } else {
        noDataMessage.classList.add("hidden");

        // Group data by species, format x and y
        const series = Object.entries(data).map(([species, records]) => {
            let groupedData;

            if (timeframe === "yearly") {
                // Group by year for the yearly view
                groupedData = records.map(item => ({
                    x: item.year.toString(),
                    y: parseInt(item.number_of_trees, 10) // Ensure numeric values
                }));
            } else {
                // Group by month and year for the monthly view
                groupedData = records.map(item => ({
                    x: `${getMonthName(item.month)} ${item.year}`, // Format as "Month Year"
                    y: parseInt(item.number_of_trees, 10) // Ensure numeric values
                }));
            }

            return {
                name: species,
                data: groupedData
            };
        });

        // Generate categories for the x-axis
        let categories = [];
        if (timeframe === "yearly") {
            // Collect unique years
            categories = [...new Set(Object.values(data).flat().map(record => record.year))];
        } else if (timeframe === "monthly") {
            // Collect unique "Month Year" values
            categories = [...new Set(Object.values(data).flat().map(record => `${getMonthName(record.month)} ${record.year}`))];
        }

        // Update the chart options
        species_chart.updateOptions({
            xaxis: {
                categories: categories, // Update categories based on timeframe
            }
        });

        // Update the chart series with the new data
        species_chart.updateSeries(series);
    }
}

function getMonthName(monthNumber) {
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    return months[monthNumber - 1]; // Convert month number to name
}


    </script>
</div>
