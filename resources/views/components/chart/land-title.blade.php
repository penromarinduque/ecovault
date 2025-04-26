<!-- When there is no desire, all things are at peace. - Laozi -->
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Land Title</h1>
        <h4 id="totalLandTitles" class="text-sm font-medium text-gray-600">Total Land Titles: 0</h4>
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

        <select id="category-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[150px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All Categories</option>
            <option value="Agricultural">Agricultural</option>
            <option value="Residential">Residential</option>
            <option value="Special">Special</option>
        </select>

        <button id="applyFilters" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>

    <div id="tcp-chart"></div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    let tcp_chart;
    const chartElement = document.getElementById("tcp-chart");
    const totalLandTitlesElement = document.getElementById("totalLandTitles");

    async function fetchChartData(location = "", timeframe = "monthly", category = "") {
        try {
            const response = await fetch(
                `/api/land-title-statistics?municipality=${location}&timeframe=${timeframe}&category=${category}`);
            const data = await response.json();

            if (data.length === 0) {
                console.warn("No data available for the selected filters.");
                tcp_chart.updateSeries([{ name: "Land Title", data: [] }]);
                totalLandTitlesElement.textContent = "Total Land Titles: 0";
                return;
            }

            let groupedData = groupData(data, timeframe);
            const totalCount = groupedData.reduce((sum, item) => sum + item.y, 0);
            totalLandTitlesElement.textContent = `Total Land Titles: ${totalCount}`;

            tcp_chart.updateSeries([{
                name: "Land Title",
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
            grouped[key] = (grouped[key] || 0) + item.total_land_titles;
        });

        return Object.entries(grouped).map(([key, value]) => ({
            x: key,
            y: value
        }));
    }

    document.addEventListener("DOMContentLoaded", () => {
        const options = {
            colors: ["#1A56DB"],
            series: [{ name: "Land Title", data: [] }],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif"
            },
            xaxis: {
                forceNiceScale: true,
                labels: { style: { fontSize: '12px' } }
            },
            yaxis: {
                show: true,
                labels: {
                    formatter: function(value) {
                        return Math.round(value); // Ensure whole numbers
                    }
                }
            },
            plotOptions: {
                bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 }
            }
        };

        tcp_chart = new ApexCharts(chartElement, options);
        tcp_chart.render();

        // Fetch initial data
        fetchChartData();

        // Apply filters when the button is clicked
        document.getElementById("applyFilters").addEventListener("click", () => {
            const location = document.getElementById("location-filter").value;
            const timeframe = document.getElementById("timeframe-filter").value;
            const category = document.getElementById("category-filter").value;
            fetchChartData(location, timeframe, category);
        });
    });
</script>
