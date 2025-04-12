<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Chainsaw Registration By Category</h3>
        <h4 id="totalRegistrations" class="text-sm font-medium text-gray-600">Total Registrations: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="crc_municipality_filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="crc_municipality_filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="All">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torijos">Torijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
            </select>
        </div>
        <div>
            <label for="crc_timeframe_filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="crc_timeframe_filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="applyCRCFilters"
            class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Apply Filters
        </button>
    </div>
    <div id="crc_chainsaw_chart"></div>
    <div id="no-data-message" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <!-- Ensure ApexCharts CDN is loaded -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof ApexCharts === "undefined") {
                console.error("ApexCharts is not defined. Ensure the library is loaded.");
                return;
            }

            let crc_chainsaw_chart;
            const crc_chartElement = document.getElementById("crc_chainsaw_chart");
            const totalRegistrationsElement = document.getElementById("totalRegistrations");
            const noDataMessage = document.getElementById("no-data-message");

            async function fetchCRCChartData(municipality = "All", timeframe = "monthly") {
                try {
                    const response = await fetch(`/api/chainsaw-registration-statistics-by-category?municipality=${municipality}&timeframe=${timeframe}`);
                    const { data, total_count } = await response.json();

                    if (!data || data.length === 0) {
                        noDataMessage.classList.remove('hidden');
                        crc_chainsaw_chart.updateSeries([
                            { name: "New Registrations", data: [] },
                            { name: "Renewals", data: [] }
                        ]);
                        return;
                    }

                    noDataMessage.classList.add('hidden');

                    // Update total registrations
                    totalRegistrationsElement.textContent = `Total Registrations: ${total_count}`;

                    // Group data for chart
                    const groupedData = groupData(data, timeframe);

                    // Update chart
                    crc_chainsaw_chart.updateSeries([
                        { name: "New Registrations", data: groupedData.newRegistrations },
                        { name: "Renewals", data: groupedData.renewals }
                    ]);
                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            function groupData(data, timeframe) {
                const newRegistrations = [];
                const renewals = [];
                data.forEach(item => {
                    const key = timeframe === "yearly" ? item.year : `${item.month} ${item.year}`; // Use month as string
                    newRegistrations.push({ x: key, y: item.new_registrations });
                    renewals.push({ x: key, y: item.renewals });
                });
                return { newRegistrations, renewals };
            }

            const options = {
                chart: { type: "bar", height: 350, fontFamily: "Inter, sans-serif" },
                colors: ["#DB1A56", "#1E88E5"],
                series: [],
                xaxis: { categories: [] },
                yaxis: {
                    title: { text: "Number of Registrations" },
                    labels: {
                        formatter: function (value) {
                            return Math.round(value); // Ensure solid numbers
                        }
                    }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } },
                dataLabels: { enabled: true }
            };

            crc_chainsaw_chart = new ApexCharts(crc_chartElement, options);
            crc_chainsaw_chart.render();

            // Fetch initial data
            fetchCRCChartData();

            // Apply filters on button click
            document.getElementById("applyCRCFilters").addEventListener("click", () => {
                const municipality = document.getElementById("crc_municipality_filter").value;
                const timeframe = document.getElementById("crc_timeframe_filter").value;
                fetchCRCChartData(municipality, timeframe);
            });
        });
    </script>
</div>