<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Tree Plantation Registrations</h1>
    </div>

    <hr class="my-4">
    </hr>

    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
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
            <label for="timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="apply-registration-filters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="tcp-chart"></div>
    <div id="no-data-message-registrations" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

    <script>
        let tcp_chart;

        document.addEventListener("DOMContentLoaded", () => {
            initializeRegistrationsChart();
            setupRegistrationsEventListeners();
            fetchRegistrationsChartData(); // Fetch initial data (monthly by default)
        });

        function initializeRegistrationsChart() {
            const options = {
                colors: ["#1A56DB"],
                series: [{ name: "Registrations", data: [] }],
                chart: { type: "bar", height: "320px", fontFamily: "Inter, sans-serif" },
                xaxis: { labels: { style: { fontSize: '12px' } } },
                yaxis: { show: true },
                plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } }
            };

            tcp_chart = new ApexCharts(document.getElementById("tcp-chart"), options);
            tcp_chart.render();
        }

        function setupRegistrationsEventListeners() {
            document.getElementById("apply-registration-filters").addEventListener("click", () => {
                const location = document.getElementById("location-filter").value;
                const timeframe = document.getElementById("timeframe-filter").value;
                fetchRegistrationsChartData(location, timeframe);
            });
        }

       async function fetchRegistrationsChartData(location = "", timeframe = "monthly") {
    try {
        const response = await fetch(`/api/tree-plantation-statistics?municipality=${location}&timeframe=${timeframe}`);
        if (!response.ok) throw new Error(`API call failed with status ${response.status}`);

        const { registrations } = await response.json();
        updateRegistrationsChart(registrations, timeframe);
    } catch (error) {
        console.error("Error fetching chart data:", error);
    }
}

function updateRegistrationsChart(data, timeframe) {
    const noDataMessage = document.getElementById("no-data-message-registrations");

    if (!data || data.length === 0) {
        noDataMessage.classList.remove("hidden");
        tcp_chart.updateSeries([{ name: "Registrations", data: [] }]);
    } else {
        noDataMessage.classList.add("hidden");
        
        let groupedData;
        
        if (timeframe === "yearly") {
            // Group by year for the yearly view
            groupedData = data.map(item => ({
                x: item.year.toString(),
                y: item.count
            }));
        } else {
            // Group by month and year for the monthly view
            groupedData = data.map(item => ({
                x: `${getMonthName(item.month)} ${item.year}`, // Format as "Month Year"
                y: item.count
            }));
        }

        // Update the chart data
        tcp_chart.updateSeries([{ name: "Registrations", data: groupedData }]);
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
