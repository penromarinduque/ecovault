<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Tree Species Transported</h3>
        <h4 id="totalSpeciesTransported" class="text-sm font-medium text-gray-600">Total Trees Transported: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="species-location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="species-location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="All">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torijos">Torijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
                <option value="Mogpog">Mogpog</option>
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
    <div id="no-data-message-species" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let species_chart;
            const species_chartElement = document.getElementById("species-chart");
            const totalSpeciesTransportedElement = document.getElementById("totalSpeciesTransported");
            const noDataSpeciesMessage = document.getElementById("no-data-message-species");

            async function fetchSpeciesChartData(municipality = "All", timeframe = "monthly") {
                try {
                    const response = await fetch(`/api/tree-species-transported-statistics?municipality=${municipality}&timeframe=${timeframe}`);
                    const { data, total_count } = await response.json();

                    if (!data || data.length === 0) {
                        noDataSpeciesMessage.classList.remove('hidden');
                        species_chart.updateSeries([]);
                        species_chart.updateOptions({ xaxis: { categories: [] } });
                        return;
                    }

                    noDataSpeciesMessage.classList.add('hidden');
                    totalSpeciesTransportedElement.textContent = `Total Trees Transported: ${total_count}`;

                    const { groupedData, categories } = groupDataBySpecies(data, timeframe);
                    species_chart.updateSeries(groupedData);
                    species_chart.updateOptions({ xaxis: { categories } });
                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            function groupDataBySpecies(data, timeframe) {
                const grouped = {};
                const categoriesSet = new Set();

                data.forEach(item => {
                    const label = timeframe === "yearly" 
                        ? `${item.year}` 
                        : `${getMonthName(item.month)} ${item.year}`;
                    categoriesSet.add(label);

                    if (!grouped[item.species]) {
                        grouped[item.species] = [];
                    }
                    grouped[item.species].push({
                        x: label,
                        y: parseInt(item.total_trees, 10)
                    });
                });

                const categories = Array.from(categoriesSet);
                const groupedData = Object.entries(grouped).map(([species, records]) => ({
                    name: species,
                    data: categories.map(category => {
                        const record = records.find(r => r.x === category);
                        return record ? record.y : 0; // Fill missing points with 0
                    })
                }));

                return { groupedData, categories };
            }

            function getMonthName(monthNumber) {
                const months = [
                    "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                return months[monthNumber - 1] || "Unknown"; // Handle invalid or undefined month numbers
            }

            const options = {
                chart: { type: "bar", height: 350, stacked: true },
                colors: ["#1A56DB", "#E91E63", "#FFC107", "#4CAF50", "#9C27B0"],
                series: [],
                xaxis: { categories: [] },
                yaxis: {
                    title: { text: "Number of Trees Transported" },
                    labels: { formatter: value => Math.round(value) }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } },
                dataLabels: { enabled: true },
                legend: { position: "top" }
            };

            species_chart = new ApexCharts(species_chartElement, options);
            species_chart.render();

            document.getElementById("apply-species-filters").addEventListener("click", () => {
                const municipality = document.getElementById("species-location-filter").value;
                const timeframe = document.getElementById("species-timeframe-filter").value;
                fetchSpeciesChartData(municipality, timeframe);
            });

            fetchSpeciesChartData();
        });
    </script>
</div>
