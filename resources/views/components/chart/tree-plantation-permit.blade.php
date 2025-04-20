<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Tree Plantation Permit</h1>
    </div>

    <hr class="my-4">
    </hr>

    <!-- Total Registrations Card -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Total Registrations</h3>
        <h4 id="totalRegistrations" class="text-sm font-medium text-gray-600">Total: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
</div>

<!-- Trees Planted By Species Card -->
<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Trees Planted By Species</h3>
      
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="species-location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="species-location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torijos">Torijos</option>
                <option value="Santa Cruz">Santa Cruz</option>
            </select>
        </div>
        <div>
            <label for="species-timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="species-timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <button id="apply-species-filters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="species-chart"></div>
    <div id="no-data-message-trees" class="hidden text-center text-gray-500">No data available for the selected filters.</div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    let tcp_chart, species_chart;

    document.addEventListener("DOMContentLoaded", () => {
        initializeCharts();
        setupEventListeners();
        fetchChartData(); // Fetch initial data
    });

    function initializeCharts() {
        const tcpOptions = {
            colors: ["#1A56DB"],
            series: [{ name: "Registrations", data: [] }],
            chart: { type: "bar", height: "320px", fontFamily: "Inter, sans-serif" },
            xaxis: { labels: { style: { fontSize: '12px' } } },
            yaxis: { show: true },
            plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } }
        };

        const speciesOptions = {
            chart: { type: "bar", height: 350, stacked: true },
            colors: ["#1A56DB", "#E91E63", "#FFC107", "#4CAF50", "#9C27B0"],
            series: [],
            xaxis: { categories: [] },
            yaxis: {
                title: { text: "Number of Trees Planted" },
                labels: { formatter: value => Math.round(value) }
            },
            plotOptions: { bar: { horizontal: false, columnWidth: "70%", borderRadius: 8 } },
            dataLabels: { enabled: true },
            legend: { position: "top" }
        };

        tcp_chart = new ApexCharts(document.getElementById("tcp-chart"), tcpOptions);
        species_chart = new ApexCharts(document.getElementById("species-chart"), speciesOptions);

        tcp_chart.render();
        species_chart.render();
    }

    function setupEventListeners() {
        document.getElementById("apply-registration-filters").addEventListener("click", () => {
            const location = document.getElementById("location-filter").value;
            const timeframe = document.getElementById("timeframe-filter").value;
            fetchChartData(location, timeframe);
        });

        document.getElementById("apply-species-filters").addEventListener("click", () => {
            const speciesLocation = document.getElementById("species-location-filter").value;
            const speciesTimeframe = document.getElementById("species-timeframe-filter").value;
            fetchChartData(speciesLocation, speciesTimeframe);
        });
    }

    async function fetchChartData(location = "", timeframe = "monthly", speciesLocation = "", speciesTimeframe = "monthly") {
        try {
            const response = await fetch(`/api/tree-plantation-statistics?municipality=${location}&timeframe=${timeframe}`);
            if (!response.ok) throw new Error(`API call failed with status ${response.status}`);

            const { registrations, speciesData, totalTreesPlanted } = await response.json();

            updateRegistrationsChart(registrations, timeframe);
            updateSpeciesChart(speciesData, speciesTimeframe);

            // Update the total trees planted
            document.getElementById("totalTreesPlanted").textContent = `Total: ${totalTreesPlanted}`;
        } catch (error) {
            console.error("Error fetching chart data:", error);
        }
    }

    function updateRegistrationsChart(data, timeframe) {
        const noDataMessage = document.getElementById("no-data-message-registrations");
        const totalRegistrationsElement = document.getElementById("totalRegistrations");

        if (!data || data.length === 0) {
            noDataMessage.classList.remove("hidden");
            tcp_chart.updateSeries([{ name: "Registrations", data: [] }]);
            totalRegistrationsElement.textContent = "Total: 0";
        } else {
            noDataMessage.classList.add("hidden");
            const groupedData = groupData(data, timeframe);
            tcp_chart.updateSeries([{ name: "Registrations", data: groupedData }]);
            totalRegistrationsElement.textContent = `Total: ${data.reduce((sum, item) => sum + item.count, 0)}`;
        }
    }

    function updateSpeciesChart(data, timeframe) {
        const noDataMessage = document.getElementById("no-data-message-trees");

        if (!data || Object.keys(data).length === 0) {
            noDataMessage.classList.remove("hidden");
            species_chart.updateSeries([]);
        } else {
            noDataMessage.classList.add("hidden");

            const series = Object.entries(data).map(([species, records]) => ({
                name: species,
                data: records.map(record => ({
                    x: timeframe === "yearly" ? record.year : `${record.year}-${record.month}`,
                    y: record.number_of_trees,
                })),
            }));

            species_chart.updateSeries(series);
        }
    }

    function groupData(data, timeframe) {
        return data.map(item => ({
            x: timeframe === "yearly" ? item.year : `${item.year}-${item.month}`,
            y: item.count || item.number_of_trees
        }));
    }

    function groupSpeciesData(data, timeframe) {
        return data.map(item => ({
            x: timeframe === "yearly" ? item.year : `${item.year}-${item.month}`,
            y: item.number_of_trees
        }));
    }
</script>