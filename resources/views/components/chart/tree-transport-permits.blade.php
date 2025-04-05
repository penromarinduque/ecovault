<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Tree Transport Permits</h1>
    </div>

    <hr class="my-4">
    </hr>

    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
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
            <label for="timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="apply-transport-filters"
            class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Apply Filters
        </button>
    </div>
    <div id="transport-chart"></div>
    <div id="no-data-message-transport" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <script>
        let transport_chart;

        document.addEventListener("DOMContentLoaded", () => {
            initializeTransportChart();
            setupTransportEventListeners();
            fetchTransportChartData(); // Fetch initial data (monthly by default)
        });

        function initializeTransportChart() {
            const options = {
                colors: ["#1A56DB"],
                series: [{ name: "Permits", data: [] }],
                chart: { type: "bar", height: "320px", fontFamily: "Inter, sans-serif" },
                xaxis: {
                    labels: { style: { fontSize: '12px' } },
                    title: { text: "Timeframe" } // Add x-axis title
                },
                yaxis: { show: true },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } }
            };

            transport_chart = new ApexCharts(document.getElementById("transport-chart"), options);
            transport_chart.render();
        }

        function setupTransportEventListeners() {
            document.getElementById("apply-transport-filters").addEventListener("click", () => {
                const location = document.getElementById("location-filter").value;
                const timeframe = document.getElementById("timeframe-filter").value;
                fetchTransportChartData(location, timeframe);
            });
        }

        async function fetchTransportChartData(location = "", timeframe = "monthly") {
            try {
                const response = await fetch(`/api/tree-transport-permit-statistics?municipality=${location}&timeframe=${timeframe}`);
                if (!response.ok) throw new Error(`API call failed with status ${response.status}`);

                const data = await response.json();
                updateTransportChart(data, timeframe);
            } catch (error) {
                console.error("Error fetching chart data:", error);
            }
        }

        function updateTransportChart(data, timeframe) {
            const noDataMessage = document.getElementById("no-data-message-transport");

            if (!data || data.length === 0) {
                noDataMessage.classList.remove("hidden");
                transport_chart.updateSeries([{ name: "Permits", data: [] }]);
                transport_chart.updateOptions({ xaxis: { categories: [] } });
            } else {
                noDataMessage.classList.add("hidden");

                const groupedData = data.map(item => ({
                    x: timeframe === "yearly" 
                        ? item.year 
                        : `${getMonthName(item.month || 1)} ${item.year}`, // Fallback to January if month is undefined
                    y: item.total_permits
                }));

                const categories = groupedData.map(item => item.x);
                const seriesData = groupedData.map(item => item.y);

                transport_chart.updateSeries([{ name: "Permits", data: seriesData }]);
                transport_chart.updateOptions({
                    xaxis: {
                        categories,
                        labels: {
                            formatter: (value) => value // Ensure correct formatting
                        }
                    }
                });
            }
        }

        function getMonthName(monthNumber) {
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            return monthNumber >= 1 && monthNumber <= 12 ? months[monthNumber - 1] : "January"; // Default to January for invalid months
        }
    </script>
</div>
