<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Chainsaw Registration By New Registration</h1>
    </div>

    <hr class="my-4">
    </hr>

    <div class="flex gap-4 py-2 w-6/12">
        <select id="crc_municipality_filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[100px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All</option>
            <option value="Gasan">Gasan</option>
            <option value="Boac">Boac</option>
            <option value="Buenavista">Buenavista</option>
            <option value="Torijos">Torijos</option>
            <option value="Santa Cruz">Santa Cruz</option>
        </select>

        <select id="crc_timeframe_filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[250px]  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>

    <div id="crc_chainsaw_chart"></div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    let crc_chainsaw_chart;
    const crc_chartElement = document.getElementById("crc_chainsaw_chart");

    async function fetchCRCChartData(municipality = "", timeframe = "monthly") {
        try {
            const response = await fetch(`/api/chainsaw-registration-statistics-by-category?municipality=${municipality}&timeframe=${timeframe}`);
            const data = await response.json();

              const { data } = await response.json();
            // Process API response
            let groupedData = groupData(data, timeframe);
            // Update the chart
            crc_chainsaw_chart.updateSeries([{ name: "Chainsaw Registration", data: groupedData }]);

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

        return Object.entries(grouped).map(([key, value]) => ({ x: key, y: value }));
            }
    document.addEventListener("DOMContentLoaded", () => {
        const options = {
            chart: { type: "bar", height: 350, fontFamily: "Inter, sans-serif" },
            colors: ["#DB1A56", "#1E88E5"],
            series: [],
            xaxis: { categories: [] },
            yaxis: { title: { text: "Number of Registrations" } },
            plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } },
            dataLabels: { enabled: true }
        };

        crc_chainsaw_chart = new ApexCharts(crc_chartElement, options);
        crc_chainsaw_chart.render();

        // Fetch initial data
        fetchCRCChartData();

        // Add event listeners for dropdown changes
        document.getElementById("crc_municipality_filter").addEventListener("change", function () {
            fetchCRCChartData(this.value, document.getElementById("crc_timeframe_filter").value);
        });

        document.getElementById("crc_timeframe_filter").addEventListener("change", function () {
            fetchCRCChartData(document.getElementById("crc_municipality_filter").value, this.value);
        });
    });
</script>