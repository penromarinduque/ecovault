@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <div class="">
        <h1 class="pl-8 font-bold text-2xl">Dashboard</h1>
        <div class="p-4  rounded-lg dark:border-gray-700">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-white border  p-4 rounded-lg shadow-md flex flex-col items-center">
                    <img src="{{ asset('images/image.svg') }}" alt="Images" class="h-16 mb-2">
                    <h2 class="text-lg font-semibold">Images</h2>
                    <p class="text-xl font-bold" id="image-count">0</p> <!-- Placeholder for image count -->
                </div>

                <div class="bg-white border  p-4 rounded-lg shadow-md flex flex-col items-center">
                    <img src="{{ asset('images/pdf.svg') }}" alt="PDFs" class="h-16 mb-2">
                    <h2 class="text-lg font-semibold">PDFs</h2>
                    <p class="text-xl font-bold" id="pdf-count">0</p> <!-- Placeholder for PDF count -->
                </div>

                <div class="bg-white border  p-4 rounded-lg shadow-md flex flex-col items-center">
                    <img src="{{ asset('images/zip.svg') }}" alt="ZIP Files" class="h-16 mb-2">
                    <h2 class="text-lg font-semibold">ZIP Files</h2>
                    <p class="text-xl font-bold" id="zip-count">0</p> <!-- Placeholder for ZIP count -->
                </div>
            </div>
            <div class="flex items-center   mb-4 rounded">
                <div class=" w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex gap-4 border-gray-200 border-b dark:border-gray-700 pb-3">
                        <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Total Files</dt>
                            <dd id="permit-total-count"
                                class="leading-none text-3xl font-bold text-gray-900 dark:text-white"></dd>
                        </dl>




                    </div>
                    <div class="mt-4">


                        <select id="filter-select"
                            class="bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <option value="monthly"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Monthly</option>
                            <option value="yearly"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Yearly</option>
                        </select>
                    </div>
                    <div id="permit-chart"></div>

                </div>

            </div>
            <div class="flex items-center   mb-4 rounded">
                <div class="grid grid-cols-3 gap-4"> <!-- Three-column grid layout for flexible sizing -->
                    <!-- Storage chart spans 1 column -->
                    <div class="h-full flex gap-2 col-span-1">
                        <x-storage-chart />
                        {{-- <x-areaChart /> --}}
                    </div>

                    <div class="col-span-2">



                    </div>



                </div>


            </div>



        </div>
    </div>
    </div>
    <script>
        fetch("/files/count")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.json(); // Parse JSON from the response
            })
            .then(data => {
                // Update the counts in the HTML
                document.getElementById("image-count").innerText = data.image_files || 0;

                document.getElementById("pdf-count").innerText = data.pdf_files || 0;
                document.getElementById("zip-count").innerText = data.zip_files || 0;

                // Optionally log the data
                console.log(data);
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });

        let chart = null;

        function fetchPermitData(timeRange = "monthly") {
            fetch(`/api/permit-statistics?time_range=${timeRange}`)
                .then(response => response.json())
                .then(data => {
                    let groupedData = {};
                    let totalPermits = 0;

                    data.forEach(item => {
                        let date = new Date(item.period).getTime(); // Convert to timestamp

                        if (!groupedData[item.municipality]) {
                            groupedData[item.municipality] = [];
                        }
                        groupedData[item.municipality].push({
                            x: date,
                            y: item.total
                        });
                        totalPermits += item.total;
                    });

                    document.querySelector("#permit-total-count").innerText = totalPermits;

                    let seriesData = Object.keys(groupedData).map(municipality => ({
                        name: municipality,
                        data: groupedData[municipality].sort((a, b) => a.x - b
                            .x) // Ensure chronological order
                    }));

                    let options = {
                        series: seriesData,
                        stroke: {
                            curve: 'smooth',
                        },
                        chart: {
                            type: "line",
                            height: 450
                        },
                        xaxis: {
                            type: "datetime",
                            title: {
                                text: timeRange === "yearly" ? "Year" : "Month & Year"
                            },
                            labels: {
                                format: timeRange === "yearly" ? "yyyy" : "MMM yyyy"
                            }
                        },
                        yaxis: {
                            title: {
                                text: "Number of Files"
                            }
                        },

                        tooltip: {
                            x: {
                                format: timeRange === "yearly" ? "yyyy" : "MMM yyyy"
                            },
                            y: {
                                formatter: val => val + " Permits"
                            }
                        }
                    };

                    if (chart) {
                        chart.destroy();
                    }

                    chart = new ApexCharts(document.querySelector("#permit-chart"), options);
                    chart.render();
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        document.querySelector("#filter-select").addEventListener("change", function() {
            fetchPermitData(this.value);
        });
        fetchPermitData();
    </script>


@endsection
