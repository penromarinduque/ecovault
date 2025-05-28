<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Tree Cutting By Species</h3>
        <h4 id="totalTCSRegistrations" class="text-sm font-medium text-gray-600">Total Trees Cut: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="tcs_municipality_filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="tcs_municipality_filter"
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
            <label for="tcs_species_filter" class="block text-sm font-medium text-gray-700">Species:</label>
            <select id="tcs_species_filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="All">All</option>
                <!-- Species options will be dynamically populated -->
            </select>
        </div>
        <div>
            <label for="tcs_timeframe_filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="tcs_timeframe_filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <div>
            <label for="tcs_startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="tcs_startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="tcs_endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="tcs_endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <button id="applyTCSFilters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="tcs_chart"></div>
    <div id="no-data-tcs-message" class="hidden text-center text-gray-500">No data available for the selected filters.
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let tcs_chart;
            const tcs_chartElement = document.getElementById("tcs_chart");
            const totalTCSRegistrationsElement = document.getElementById("totalTCSRegistrations");
            const noDataTCSMessage = document.getElementById("no-data-tcs-message");

            // Fetch species options for the filter
            async function fetchSpeciesOptions() {
                try {
                    const response = await fetch(`/api/tree-species`);
                    const species = await response.json();
                    const speciesFilter = document.getElementById("tcs_species_filter");

                    species.forEach(speciesItem => {
                        if (speciesItem.common_name) {
                            const option = document.createElement("option");
                            option.value = speciesItem.common_name;
                            option.textContent = speciesItem.common_name;
                            speciesFilter.appendChild(option);
                        }
                    });
                } catch (error) {
                    console.error("Error fetching species options:", error);
                }
            }

            // Fetch chart data based on filters
            async function fetchTCSChartData(municipality = "All", timeframe = "monthly", species = "All",
                startDate = null, endDate = null) {
                try {
                    const url = new URL('/api/tree-cutting-species-statistics', window.location.origin);
                    url.searchParams.append('municipality', municipality);
                    url.searchParams.append('timeframe', timeframe);
                    url.searchParams.append('species', species);

                    if (startDate) {
                        url.searchParams.append('start_date', startDate);
                    }
                    if (endDate) {
                        url.searchParams.append('end_date', endDate);
                    }

                    // Debugging: Log the final URL
                    console.log("Final URL:", url.toString());

                    const response = await fetch(url);
                    if (!response.ok) throw new Error("Failed to fetch data");
                    const {
                        data,
                        total_count
                    } = await response.json();

                    if (!data || data.length === 0) {
                        noDataTCSMessage.classList.remove('hidden');
                        tcs_chart.updateSeries([]);
                        tcs_chart.updateOptions({
                            xaxis: {
                                categories: []
                            }
                        });
                        return;
                    }

                    noDataTCSMessage.classList.add('hidden');
                    totalTCSRegistrationsElement.textContent = `Total Trees Cut: ${total_count}`;

                    const groupedData = data.map(item => ({
                        x: timeframe === "yearly" ? item.year.toString() :
                            `${item.month} ${item.year}`,
                        y: Number(item.total_trees)
                    }));

                    const xCategories = groupedData.map(item => item.x);

                    tcs_chart.updateOptions({
                        xaxis: {
                            categories: xCategories
                        },
                        series: [{
                            name: species === "All" ? "All Species" : species,
                            data: groupedData.map(item => item.y)
                        }]
                    });
                } catch (error) {
                    console.error("Error fetching chart data:", error);
                }
            }

            const options = {
                chart: {
                    type: "bar",
                    height: 350
                },
                colors: ["#1A56DB"],
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
                }
            };

            tcs_chart = new ApexCharts(tcs_chartElement, options);
            tcs_chart.render();

            document.getElementById("applyTCSFilters").addEventListener("click", () => {
                const startDateElement = document.getElementById("tcs_startDateFilter");
                const endDateElement = document.getElementById("tcs_endDateFilter");

                console.log("Start Date Element:", startDateElement);
                console.log("End Date Element:", endDateElement);

                if (!startDateElement || !endDateElement) {
                    alert("Start Date or End Date input is missing in the DOM.");
                    return;
                }

                const startDate = startDateElement.value;
                const endDate = endDateElement.value;

                console.log("Start Date Value:", startDate);
                console.log("End Date Value:", endDate);

                if (!startDate || !endDate) {
                    alert("Please select both start and end dates.");
                    return;
                }

                const municipality = document.getElementById("tcs_municipality_filter").value;
                const timeframe = document.getElementById("tcs_timeframe_filter").value;
                const species = document.getElementById("tcs_species_filter").value;

                fetchTCSChartData(municipality, timeframe, species, startDate, endDate);
            });

            fetchSpeciesOptions();
            fetchTCSChartData();
        });
    </script>
</div>
