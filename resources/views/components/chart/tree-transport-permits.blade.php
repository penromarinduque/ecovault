<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="justify-between flex">
        <h1 class="font-bold">Tree Transport Permits</h1>
    </div>

    <hr class="my-4">
    </hr>

    <div class="flex items-center space-x-4 mb-4">
        <div>
            <label for="location-filter" class="block text-sm font-medium text-gray-700">Municipality:</label>
            <select id="location-filter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="">All</option>
                <option value="Gasan">Gasan</option>
                <option value="Boac">Boac</option>
                <option value="Buenavista">Buenavista</option>
                <option value="Torrijos">Torrijos</option>
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

        <div>
            <label for="ttp_startDateFilter" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="ttp_startDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>
        <div>
            <label for="ttp_endDateFilter" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="ttp_endDateFilter"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>

        <button id="apply-transport-filters"
            class="mt-6 px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Apply Filters
        </button>
    </div>
    <div id="transport-chart"></div>
    <div id="no-data-message-transport" class="hidden text-center text-gray-500">No data available for the selected filters.</div>
   
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function loadTransportChart() {
        const municipality = document.getElementById('location-filter').value;
        const timeframe = document.getElementById('timeframe-filter').value;
        const startDate = document.getElementById('ttp_startDateFilter').value;
        const endDate = document.getElementById('ttp_endDateFilter').value;
        const url = new URL('/api/tree-transport-permit-statistics', window.location.origin);
        url.searchParams.append('municipality', municipality);
        url.searchParams.append('timeframe', timeframe);    
        if (startDate) {
            url.searchParams.append('start_date', startDate);
        }
        if (endDate) {
            url.searchParams.append('end_date', endDate);
        }

        fetch(url)
            .then(response => response.json())
            .then(res => {
                const chartData = res.data;

                const chartContainer = document.getElementById('transport-chart');
                const noDataMessage = document.getElementById('no-data-message-transport');

                if (!chartData.length) {
                    chartContainer.innerHTML = '';
                    noDataMessage.classList.remove('hidden');
                    return;
                }

                noDataMessage.classList.add('hidden');

                const categories = [];
                const seriesData = [];

                chartData.forEach(item => {
                    const label = timeframe === 'yearly' ? `${item.year}` : `${item.month} ${item.year}`;
                    categories.push(label);
                    seriesData.push(item.count);
                });

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Transport Permits',
                        data: seriesData
                    }],
                    xaxis: {
                        categories: categories
                    },
                    colors: ['#16a34a'],
                    tooltip: {
                        y: {
                            formatter: val => `${val} permit(s)`
                        }
                    }
                };

                chartContainer.innerHTML = ''; // Clear old chart
                const chart = new ApexCharts(chartContainer, options);
                chart.render();
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                document.getElementById('transport-chart').innerHTML = '';
                document.getElementById('no-data-message-transport').classList.remove('hidden');
            });
    }

    document.addEventListener('DOMContentLoaded', loadTransportChart);
    document.getElementById('apply-transport-filters').addEventListener('click', loadTransportChart);
</script>
