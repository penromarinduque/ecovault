<!-- When there is no desire, all things are at peace. - Laozi -->
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Transport Permit</h1>
        {{-- <h2>Total Permits: <span>0</span></h2> --}}
    </div>

    <hr class="my-4">
    </hr>

    <div class="flex gap-4 py-2 w-6/12">
        <select id="location-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[100px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All</option>
            <option value="Gasan">Gasan</option>
            <option value="Boac">Boac</option>
            <option value="Buenavista">Buenavista</option>
            <option value="Torrijos">Torrijos</option>
            <option value="Santa Cruz">Santa Cruz</option>
        </select>

        <select id="timeframe-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[250px]  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>

    <div id="tcp-chart"></div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    let tcp_chart;
    const chartElement = document.getElementById("tcp-chart");

    async function fetchChartData(location = "", timeframe = "monthly") {
        try {
            // Call the Laravel API with filters
            const response = await fetch(
                `/api/land-statistics?municipality=${location}&timeframe=${timeframe}`);
            const {
                data
            } = await response.json();
            // Process API response
            let groupedData = groupData(data, timeframe);
            // Update the chart
            tcp_chart.updateSeries([{
                name: "Transport Permit",
                data: groupedData
            }]);

        } catch (error) {
            console.error("Error fetching chart data:", error);
        }
    }

    function groupData(data, timeframe) {
        const grouped = {};

        data.forEach(item => {
            const key = timeframe === "yearly" ? item.year : `${item.year}-${item.month}`;
            grouped[key] = (grouped[key] || 0) + item.count;
        });

        return Object.entries(grouped).map(([key, value]) => ({
            x: key,
            y: value
        }));
    }

    document.addEventListener("DOMContentLoaded", () => {
        // Initial chart setup
        const options = {
            colors: ["#1A56DB"],
            series: [{
                name: "Transport Permit",
                data: []
            }],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif"
            },
            xaxis: {
                forceNiceScale: true,
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                show: true
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

        // Fetch initial data
        fetchChartData();

        // Add event listeners for dropdown changes
        document.getElementById("location-filter").addEventListener("change", function() {
            fetchChartData(this.value, document.getElementById("timeframe-filter").value);
        });

        document.getElementById("timeframe-filter").addEventListener("change", function() {
            fetchChartData(document.getElementById("location-filter").value, this.value);
        });
    });
</script>
