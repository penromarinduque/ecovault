<div>
    <div class="flex gap-4 py-2 w-6/12">
        <select id="tcs-location-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[100px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All</option>
            <option value="Gasan">Gasan</option>
            <option value="Boac">Boac</option>
            <option value="Buenavista">Buenavista</option>
            <option value="Torijos">Torijos</option>
            <option value="Santa Cruz">Santa Cruz</option>
        </select>

        <select id="tcs-timeframe-filter"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[250px]  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
    <div id="tcs-chart"></div>
</div>

<script>
    let tcsChart; // Store chart instance to update later

    async function fetchTreeCuttingSpeciesData(location = "", timeframe = "monthly") {
        try {
            const url = `/api/tree-cutting-species-statistics?timeframe=${timeframe}&location=${location}`;
            const response = await fetch(url);
            return await response.json();
        } catch (error) {
            console.error("Error fetching tree-cutting data:", error);
        }
    }

   async function formatChartData(location = "", timeframe = "monthly") {
        const rawData = await fetchTreeCuttingSpeciesData(location, timeframe);

        // Dynamically use year for yearly, month for monthly
        const uniqueLabels = timeframe === "yearly"
            ? [...new Set(rawData.map(row => row.year))].sort()  // Use years
            : [...new Set(rawData.map(row => row.month))].sort(); // Use month-year

        const speciesMap = {};

        rawData.forEach(row => {
            const { species, year, month, total_trees } = row;
            const label = timeframe === "yearly" ? year : month; // Use correct label dynamically

            if (!speciesMap[species]) {
                speciesMap[species] = uniqueLabels.reduce((acc, lbl) => {
                    acc[lbl] = 0;
                    return acc;
                }, {});
            }

            speciesMap[species][label] = total_trees; // Assign values correctly
        });

        const series = Object.keys(speciesMap).map(species => ({
            name: species,
            data: uniqueLabels.map(label => speciesMap[species][label] || 0) // Ensure correct mapping
        }));

        return { series, categories: uniqueLabels }; // ✅ Use uniqueLabels instead of uniqueMonths
    }


    async function renderTCSChart() {
        const location = document.getElementById("tcs-location-filter").value;
        const timeframe = document.getElementById("tcs-timeframe-filter").value;
        const chartData = await formatChartData(location, timeframe);

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
                title: { text: 'Total Trees Cut' },
                labels: {
                    formatter: function (value) {
                        return Math.floor(value); // Ensures only whole numbers
                    }
                }
            }
        };

        if (tcsChart) {
            tcsChart.updateOptions(options); // Update chart instead of re-creating
        } else {
            tcsChart = new ApexCharts(document.querySelector("#tcs-chart"), options);
            tcsChart.render();
        }
    }

    // Attach event listeners for dropdowns
    document.getElementById("tcs-location-filter").addEventListener("change", renderTCSChart);
    document.getElementById("tcs-timeframe-filter").addEventListener("change", renderTCSChart);

    // Initial render
    renderTCSChart();
</script>