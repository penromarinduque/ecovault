<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between mb-3">
        <div class="flex justify-center items-center">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Storage</h5>
        </div>
        <div>
            <button type="button" data-tooltip-target="data-tooltip" data-tooltip-placement="bottom"
                class="hidden sm:inline-flex items-center justify-center text-gray-500 w-8 h-8 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 16 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3" />
                </svg><span class="sr-only">Download data</span>
            </button>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="py-6" id="donut-chart"></div>
</div>

<script>
    // Function to get chart options
    const getChartOptions = (storageData) => {
        return {
            series: [storageData.penro_space, storageData.other_space, storageData.free_space],
            colors: ["#1C64F2", "#16BDCA", "#FDBA8C"],
            chart: {
                height: 320,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Total Storage",
                                fontFamily: "Inter, sans-serif",
                                formatter: function(w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return sum.toFixed(2) + ' GB';
                                },
                            },
                            value: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: -20,
                                formatter: function(value) {
                                    return value.toFixed(2) + " GB";
                                },
                            },
                        },
                        size: "80%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: ["PENRO Space", "Other Files", "Free Space"],
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        };
    };

    // Fetch storage data from the Laravel API and initialize the chart
    fetch('/staff/storage-usage')
        .then(response => response.json())
        .then(data => {
            if (data && !data.error) {
                console.log('Storage Data:', data); // Debugging: Log the fetched data
                const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions(data));
                chart.render();
            } else {
                console.error('Error fetching storage data:', data.error);
            }
        })
</script>
