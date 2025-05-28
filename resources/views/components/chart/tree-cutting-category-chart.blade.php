<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Tree Cutting By Category</h3>
        <h4 id="totalTCCRegistrations" class="text-sm font-medium text-gray-600">Total Trees Cut: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="tcc_municipality_filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="tcc_municipality_filter"
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
            <label for="tcc_timeframe_filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="tcc_timeframe_filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <div>
            <label for="tcc_startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="tcc_startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="tcc_endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="tcc_endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <button id="applyTCCFilters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="tcc_chart"></div>
    <div id="no-data-tcc-message" class="hidden text-center text-gray-500">No data available for the selected filters.
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let tcc_chart;
            const tcc_chartElement = document.getElementById("tcc_chart");
            const totalTCCRegistrationsElement = document.getElementById("totalTCCRegistrations");
            const noDataTCCMessage = document.getElementById("no-data-tcc-message");

            async function fetchTCCChartData(municipality = "All", timeframe = "monthly", startDate = null,
                endDate = null) {
                try {
                    const url = new URL('/api/tree-cutting-category-statistics', window.location.origin);
                    url.searchParams.append('municipality', municipality);
                    url.searchParams.append('timeframe', timeframe);
                    // url.searchParams.append('species', species);

                    if (startDate) {
                        url.searchParams.append('start_date', startDate);
                    }
                    if (endDate) {
                        url.searchParams.append('end_date', endDate);
                    }

                    const response = await fetch(url);
                    const {
                        data,
                        total_count
                    } = await response.json();

                    if (!data || data.length === 0) {
                        noDataTCCMessage.classList.remove('hidden');
                        tcc_chart.updateSeries([]);
                        tcc_chart.updateOptions({
                            xaxis: {
                                categories: []
                            }
                        });
                        return;
                    }

                    noDataTCCMessage.classList.add('hidden');
                    totalTCCRegistrationsElement.textContent = `Total Trees Cut: ${total_count}`;

                    // Group data by category
                    const categories = [...new Set(data.map(item => item.permit_type))];

                    const xAxisLabels = [...new Set(
                        data.map(item => timeframe === "yearly" ? item.year.toString() :
                            `${item.month} ${item.year}`)
                    )];

                    const groupedData = categories.map(category => ({
                        name: category,
                        data: xAxisLabels.map(label => {
                            const found = data.find(item => {
                                const itemLabel = timeframe === "yearly" ? item.year
                                    .toString() : `${item.month} ${item.year}`;
                                return item.permit_type === category &&
                                    itemLabel === label;
                            });
                            return {
                                x: label,
                                y: found ? found.total_trees : 0
                            };
                        })
                    }));

                    tcc_chart.updateSeries(groupedData);
                    tcc_chart.updateOptions({
                        xaxis: {
                            categories: xAxisLabels
                        }
                    });

                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            const options = {
                chart: {
                    type: "bar",
                    height: 350,
                    stacked: true
                },
                colors: ["#1A56DB", "#E91E63", "#FFC107", "#4CAF50", "#9C27B0"],
                series: [],
                xaxis: {
                    categories: []
                },
                yaxis: {
                    title: {
                        text: "Number of Trees Cut"
                    },
                    labels: {
                        formatter: value => Math.round(value)
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadius: 8
                    }
                },
                dataLabels: {
                    enabled: true
                },
                legend: {
                    position: "top"
                }
            };

            tcc_chart = new ApexCharts(tcc_chartElement, options);
            tcc_chart.render();

            document.getElementById("applyTCCFilters").addEventListener("click", () => {
                const municipality = document.getElementById("tcc_municipality_filter").value;
                const timeframe = document.getElementById("tcc_timeframe_filter").value;
                const startDate = document.getElementById("tcc_startDateFilter").value;
                const endDate = document.getElementById("tcc_endDateFilter").value;
                console.log("Start Date:", startDate);
                console.log("End Date:", endDate);
                fetchTCCChartData(municipality, timeframe, startDate, endDate);
            });

            fetchTCCChartData();
        });
    </script>
</div>
