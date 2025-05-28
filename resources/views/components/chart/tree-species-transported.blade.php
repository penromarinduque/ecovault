<div class="bg-white shadow-md rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Tree Species Transported</h3>
        <h4 id="totalSpeciesTransported" class="text-sm font-medium text-gray-600">Total Trees Transported: 0</h4>
    </div>
    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="species-location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="species-location-filter"
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
            <label for="species-timeframe-filter" class="block text-sm font-medium text-gray-700">Timeframe:</label>
            <select id="species-timeframe-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>
        <div>
            <label for="species-filter" class="block text-sm font-medium text-gray-700">Species:</label>
            <select id="species-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="All">All</option>
                {{-- Species options will be dynamically populated --}}
            </select>
        </div>


        <div>
            <label for="species_startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="species_startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="species_endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="species_endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <button id="apply-species-filters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="species-chart"></div>
    <div id="no-data-message-species" class="hidden text-center text-gray-500">No data available for the selected
        filters.</div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        async function loadSpeciesOptions() {
            const speciesSelect = document.getElementById('species-filter');
            try {
                const res = await fetch('/api/tree-transport-species');
                const data = await res.json();

                speciesSelect.innerHTML = `<option value="All">All</option>`;
                data.forEach(species => {
                    const option = document.createElement('option');
                    option.value = species;
                    option.textContent = species;
                    speciesSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Failed to load species options:', error);
            }
        }

        async function loadSpeciesChart() {
            const municipality = document.getElementById('species-location-filter').value;
            const timeframe = document.getElementById('species-timeframe-filter').value;
            const species = document.getElementById('species-filter').value;
            const startDate = document.getElementById('species_startDateFilter').value;
            const endDate = document.getElementById('species_endDateFilter').value;

            const chartContainer = document.getElementById('species-chart');
            const noDataMessage = document.getElementById('no-data-message-species');
            const totalDisplay = document.getElementById('totalSpeciesTransported');

            const params = new URLSearchParams({
                municipality: municipality === 'All' ? '' : municipality,
                timeframe,
                species: species === 'All' ? '' : species,
                startDate: startDate || '',
                endDate: endDate || '',
            });

            try {
                const res = await fetch(`/api/tree-species-transported-statistics?${params.toString()}`);
                const result = await res.json();

                const data = result.data || [];
                const total = result.total_count || 0;

                if (!data.length) {
                    chartContainer.innerHTML = '';
                    noDataMessage.classList.remove('hidden');
                    totalDisplay.textContent = 'Total Trees Transported: 0';
                    return;
                }

                noDataMessage.classList.add('hidden');
                totalDisplay.textContent = `Total Trees Transported: ${total}`;

                const categories = [];
                const seriesData = [];

                data.forEach(item => {
                    const label = timeframe === 'yearly' ?
                        `${item.year}` :
                        `${item.month} ${item.year}`;
                    categories.push(label);
                    seriesData.push(parseInt(item.total_trees));
                });

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Total Trees',
                        data: seriesData
                    }],
                    xaxis: {
                        categories: categories
                    },
                    colors: ['#10B981'], // Tailwind green-500
                    tooltip: {
                        y: {
                            formatter: val => `${val} tree(s)`
                        }
                    }
                };

                chartContainer.innerHTML = ''; // Clear existing
                const chart = new ApexCharts(chartContainer, options);
                chart.render();

            } catch (error) {
                console.error('Failed to load chart:', error);
                chartContainer.innerHTML = '';
                noDataMessage.classList.remove('hidden');
                totalDisplay.textContent = 'Total Trees Transported: 0';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadSpeciesOptions().then(loadSpeciesChart);
        });

        document.getElementById('apply-species-filters').addEventListener('click', loadSpeciesChart);
    </script>


</div>
