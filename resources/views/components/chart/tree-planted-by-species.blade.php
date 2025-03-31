<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Trees Planted By Species</h3>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="species-location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="species-location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torijos">Torijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
            </select>
        </div>
        <div>
            <label for="species-timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="species-timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="apply-species-filters"
            class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                fetchSpeciesChartData(location, timeframe);
            });
        }

        async function fetchSpeciesChartData(location = "", timeframe = "monthly") {
            try {
                const response = await fetch(`/api/tree-plantation-statistics?municipality=${location}&timeframe=${timeframe}`);
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
                species_chart.updateSeries([]);
            } else {
                noDataMessage.classList.add("hidden");

                const series = Object.entries(data).map(([species, records]) => ({
                    name: species,
                    data: records.map(record => ({
                        x: timeframe === "yearly" 
                            ? record.year 
                            : `${getMonthName(record.month)} ${record.year}`, // Format month as name
                        y: record.number_of_trees,
                    })),
                }));

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
