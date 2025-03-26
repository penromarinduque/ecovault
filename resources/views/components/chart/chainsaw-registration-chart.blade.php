<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Chainsaw Registration</h1>
    </div>
    <div class="flex gap-4 py-2 w-6/12">
        <select id="cr-location-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[100px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All</option>
            <option value="Gasan">Gasan</option>
            <option value="Boac">Boac</option>
            <option value="Buenavista">Buenavista</option>
            <option value="Torijos">Torijos</option>
            <option value="Santa Cruz">Santa Cruz</option>
        </select>

        <select id="cr-timeframe-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[250px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
    <div id="cr-chart"></div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", async function () {
        const locationFilter = document.getElementById("cr-location-filter");
        const timeframeFilter = document.getElementById("cr-timeframe-filter");
        const chartContainer = document.getElementById("cr-chart");
        let chart;

        async function fetchChainsawData(location = "", timeframe = "monthly") {
            try {
                const url = `/api/chainsaw-registration-statistics?timeframe=${timeframe}&municipality=${location}`;
                const response = await fetch(url);
                return await response.json();
            } catch (error) {
                console.error("Error fetching chainsaw data:", error);
                return [];
            }
        }

        async function updateChart() {
            const location = locationFilter.value;
            const timeframe = timeframeFilter.value;
            const data = await fetchChainsawData(location, timeframe);

            if (!data.length) {
                console.warn("No data available");
                chartContainer.innerHTML = "<p class='text-gray-500'>No data available</p>";
                return;
            }

            const categories = timeframe === "monthly"
                ? data.map(item => `${item.month} ${item.year}`)
                : data.map(item => item.year);

            const seriesData = data.map(item => item.total_permits);

            const options = {
                chart: {
                    type: "bar",
                    height: 350,
                    toolbar: { show: false }
                },
                series: [{
                    name: "Total Permits",
                    data: seriesData
                }],
                xaxis: {
                    categories: categories
                },
                colors: ["#1E88E5"],
                dataLabels: {
                    enabled: false
                }
            };

            // Destroy previous chart instance if exists
            if (chart) {
                chart.destroy();
            }

            chart = new ApexCharts(chartContainer, options);
            chart.render();
        }

        locationFilter.addEventListener("change", updateChart);
        timeframeFilter.addEventListener("change", updateChart);

        updateChart();
    });

</script>