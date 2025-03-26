<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Tree Cutting Permit</h1>
        {{-- <h2>Total Permits: <span>0</span></h2> --}}
    </div>
    <div class="flex gap-4 py-2 w-6/12">
        <select id="tcc-location-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[100px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All</option>
            <option value="Gasan">Gasan</option>
            <option value="Boac">Boac</option>
            <option value="Buenavista">Buenavista</option>
            <option value="Torijos">Torijos</option>
            <option value="Santa Cruz">Santa Cruz</option>
        </select>

        <select id="tcc-timeframe-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[250px]  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
    <div id="tcc-chart"></div>
</div>

<script>
    let tccChart; // Store chart instance to update later
    
    async function fetchTreeCuttingCategoryData(location = "", timeframe = "monthly") {
        try {
            const url = `/api/tree-cutting-category-statistics?timeframe=${timeframe}&municipality=${location}`;
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error("Error fetching tree-cutting data:", error);
        }
    }

  async function formatChartCategoryData(location = "", timeframe = "monthly") {
        const rawData = await fetchTreeCuttingCategoryData(location, timeframe);

        // Convert month abbreviations to ensure correct order
        const monthOrder = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        // Generate unique labels: "Mar 2025" for monthly, "2025" for yearly
        const uniqueLabels = timeframe === "yearly"
            ? [...new Set(rawData.map(row => row.year))].sort()
            : [...new Set(rawData.map(row => `${row.month} ${row.year}`))]
                .sort((a, b) => {
                    const [monthA, yearA] = a.split(" ");
                    const [monthB, yearB] = b.split(" ");
                    return yearA - yearB || monthOrder.indexOf(monthA) - monthOrder.indexOf(monthB);
                });

        const permitTypeMap = {};

        rawData.forEach(row => {
            const { permit_type, year, month, total_trees } = row;
            const label = timeframe === "yearly" ? year : `${month} ${year}`; // Format as "Mar 2025"

            if (!permitTypeMap[permit_type]) {
                permitTypeMap[permit_type] = uniqueLabels.reduce((acc, lbl) => {
                    acc[lbl] = 0;
                    return acc;
                }, {});
            }

            permitTypeMap[permit_type][label] = parseInt(total_trees, 10);
        });

        const series = Object.keys(permitTypeMap).map(permit_type => ({
            name: permit_type,
            data: uniqueLabels.map(label => permitTypeMap[permit_type][label] || 0)
        }));

        return { series, categories: uniqueLabels };
    }



    async function renderTCCChart() {
        const location = document.getElementById("tcc-location-filter").value;
        const timeframe = document.getElementById("tcc-timeframe-filter").value;
        const chartData = await formatChartCategoryData(location, timeframe);

        const options = {
            chart: {
                type: 'bar',
                stacked: true,
                height: 300
            },
            series: chartData.series,
            xaxis: {
                categories: chartData.categories,
            },
            yaxis: {
                title: { text: 'Total Trees Cut Per Category' },
                labels: {
                    formatter: function (value) {
                        return Math.floor(value); // Ensures only whole numbers
                    }
                }
            }
        };

        if (tccChart) {
            tccChart.updateOptions(options); // Update chart instead of re-creating
        } else {
            tccChart = new ApexCharts(document.querySelector("#tcc-chart"), options);
            tccChart.render();
        }
    }

    // Attach event listeners for dropdowns
    document.getElementById("tcc-location-filter").addEventListener("change", renderTCCChart);
    document.getElementById("tcc-timeframe-filter").addEventListener("change", renderTCCChart);

    // Initial render
    renderTCCChart();
</script>