<div class="bg-white shadow-md rounded-lg p-4">
    <img src="{{ asset('images/reports/chainsaw registration.png') }}" alt="Chainsaw Registration" class="w-20">

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Chainsaw Registration</h3>
        <h4 id="totalPermits" class="text-sm font-medium text-gray-600">Total Permits: 0</h4>
    </div>

    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="">All</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Mogpog">Mogpog</option>
                <option value="Santa Cruz">Santa Cruz</option>
                <option value="Torrijos">Torrijos</option>
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
        <div>
            <label for="cr_startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="cr_startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="cr_endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="cr_endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <button id="applyChainsawFilters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>

    <div id="tcp-chart"></div>
    <div id="no-data-message" class="hidden text-center text-gray-500">No data available for the selected filters.</div>

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

            async function fetchChartData(location = "All", timeframe = "monthly", start_date, end_date) {
                try {
                    const url = new URL('/api/chainsaw-registration-statistics', window.location.origin);
                    url.searchParams.append('municipality', location);
                    url.searchParams.append('timeframe', timeframe);
                    if (start_date) url.searchParams.append('start_date', start_date);
                    if (end_date) url.searchParams.append('end_date', end_date);

                    const response = await fetch(url);
                    const {
                        data,
                        total_count
                    } = await response.json();

                    if (!data || data.length === 0) {
                        noDataMessage.classList.remove('hidden');
                        tcp_chart.updateSeries([{
                            name: "Chainsaw Registration",
                            data: []
                        }]);
                        return;
                    }

                    noDataMessage.classList.add('hidden');

                    const groupedData = groupData(data, timeframe);

                    // Update total permits
                    totalPermitsElement.textContent = `Total Permits: ${total_count}`;

                    // Update chart data
                    tcp_chart.updateSeries([{
                        name: "Chainsaw Registration",
                        data: groupedData.data
                    }]);
                    tcp_chart.updateOptions({
                        xaxis: {
                            categories: groupedData.categories,
                            labels: {
                                style: {
                                    fontSize: '12px'
                                }
                            },
                        },
                    });

                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            function groupData(data, timeframe) {
                const categories = [];
                const chartData = [];

                data.forEach(item => {
                    let label = "";
                    if (timeframe === "yearly") {
                        label = item.year.toString();
                    } else if (timeframe === "monthly") {
                        label = `${item.month} ${item.year}`;
                    }

                    if (!categories.includes(label)) {
                        categories.push(label);
                    }

                    chartData.push({
                        x: label,
                        y: item.total_permits
                    });
                });

                return {
                    categories,
                    data: chartData
                };
            }

            const options = {
                colors: ["#1A56DB"],
                series: [{
                    name: "Chainsaw Registration",
                    data: []
                }],
                chart: {
                    type: "bar",
                    height: 320,
                    fontFamily: "Inter, sans-serif"
                },
                xaxis: {
                    categories: [],
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    show: true,
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadius: 8
                    }
                }
            };

            tcp_chart = new ApexCharts(chartElement, options);
            tcp_chart.render();

            // Initial fetch
            fetchChartData();

            // Apply filter button
            document.getElementById("applyChainsawFilters").addEventListener("click", () => {
                const location = document.getElementById("location-filter").value;
                const timeframe = document.getElementById("timeframe-filter").value;
                const startDate = document.getElementById("cr_startDateFilter").value;
                const endDate = document.getElementById("cr_endDateFilter").value;
                fetchChartData(location, timeframe, startDate, endDate);
            });
        });
    </script>
</div>
