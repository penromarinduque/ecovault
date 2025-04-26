<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Chainsaw Registration</h3>
        <h4 id="totalPermits" class="text-sm font-medium text-gray-600">Total Permits: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="All">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torrijos">Torrijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
            </select>
        </div>
        <div>
            <label for="timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="applyChainsawFilters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="tcp-chart"></div>
    <div id="no-data-message" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <!-- Ensure ApexCharts CDN is loaded -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof ApexCharts === "undefined") {
                console.error("ApexCharts is not defined. Ensure the library is loaded.");
                return;
            }

            let tcp_chart;
            const chartElement = document.getElementById("tcp-chart");
            const totalPermitsElement = document.getElementById("totalPermits");
            const noDataMessage = document.getElementById("no-data-message");

            async function fetchChartData(location = "All", timeframe = "monthly") {
                try {
                    const response = await fetch(`/api/chainsaw-registration-statistics?municipality=${location}&timeframe=${timeframe}`);
                    const { data, total_count } = await response.json();

                    if (!data || data.length === 0) {
                        noDataMessage.classList.remove('hidden');
                        tcp_chart.updateSeries([{ name: "Chainsaw Registration", data: [] }]);
                        return;
                    }

                    noDataMessage.classList.add('hidden');

                    const groupedData = groupData(data, timeframe);

                    // Update total permits
                    totalPermitsElement.textContent = `Total Permits: ${total_count}`;

                    // Update chart
                    tcp_chart.updateSeries([{ name: "Chainsaw Registration", data: groupedData }]);
                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            function groupData(data, timeframe) {
                return data.map(item => {
                    const key = timeframe === "yearly" ? item.year : `${item.month} ${item.year}`;
                    return { x: key, y: item.total_permits };
                });
            }

            const options = {
                colors: ["#1A56DB"],
                series: [{ name: "Chainsaw Registration", data: [] }],
                chart: { type: "bar", height: 320, fontFamily: "Inter, sans-serif" },
                xaxis: { labels: { style: { fontSize: '12px' } } },
                yaxis: {
                    show: true,
                    labels: {
                        formatter: function (value) {
                            return Math.round(value); // Ensure solid numbers
                        }
                    }
                },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } }
            };

            tcp_chart = new ApexCharts(chartElement, options);
            tcp_chart.render();

            // Fetch initial data
            fetchChartData();

            // Apply filters on button click
            document.getElementById("applyChainsawFilters").addEventListener("click", () => {
                const location = document.getElementById("location-filter").value;
                const timeframe = document.getElementById("timeframe-filter").value;
                fetchChartData(location, timeframe);
            });
        });
    </script>
</div>