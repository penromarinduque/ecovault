@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="p-6 bg-white shadow-md rounded-md max-w-lg mx-auto">
        <h1 class="text-lg font-bold text-blue-600 border-b-2 border-blue-600 pb-2 mb-4">File Summary</h1>

        <div id="child-file-summary-div">
            <!-- File Name -->
            <div class="relative z-0 w-full mb-6 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-lg font-medium text-gray-800 px-4">File Name:</span>
                    <span id="summary-file-name" class="text-gray-500 font-semibold pl-4">N/A</span>
                </div>
            </div>

            <!-- Conditional: Name of Client -->
            @if (!$record)
                <div class="relative z-0 w-full mb-6 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <span class="text-lg font-medium text-gray-800 px-4">Name of Client:</span>
                        <span id="summary-name-of-client" class="text-gray-500 capitalize font-semibold pl-4">N/A</span>
                    </div>
                </div>
            @endif

            <!-- Office Source -->
            <div class="relative z-0 w-full mb-6 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-lg font-medium text-gray-800 px-4">Office Source:</span>
                    <span id="summary-office-source" class="text-gray-500 capitalize font-semibold pl-4">N/A</span>
                </div>
            </div>

            <!-- Classification -->
            <div class="relative z-0 w-full mb-6 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-gray-50 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <span class="text-lg font-medium text-gray-800 px-4 ">Classification:</span>
                    <span id="summary-classification" class="text-gray-500 capitalize font-semibold pl-4">N/A</span>
                </div>
            </div>
        </div>



        {{-- @if ($type == 'tree-plantation-registration')
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Number of Trees:</span>
                        <span id="summary-number-of-trees" class="text-gray-500 capitalize font-semibold pl-4 "> </span>
                    </div>
                </div>
            @endif
            @if (in_array($type, ['chainsaw-registration', 'tree-plantation-registration', 'land-titles']))
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Location:</span>
                        <span id="summary-location" class="text-gray-500 capitalize font-semibold pl-4 "> </span>
                    </div>
                </div>
            @endif
            @if ($type == 'chainsaw-registration' ||
    $type ==
        'tree-plantation-registration
                                                                                                                                                                                                ')
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Date Applied:</span>
                        <span id="summary-date-applied" class="text-gray-500 capitalize font-semibold pl-4 "> </span>
                    </div>
                </div>
            @endif
            <!-- Conditional fields based on permit type -->

            @if ($type == 'chainsaw-registration')
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Serial Number:</span>
                        <span id="summary-serial-number" class="text-gray-500 capitalize font-semibold pl-4 "> </span>
                    </div>
                </div>
            @endif


            @if ($type == 'land-title')
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Lot Number:</span>
                        <span id="summary-lot-number" class="text-gray-500 capitalize font-semibold pl-4 "> </span>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <div
                        class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <span class="text-lg font-medium text-gray-800">Property Category:</span>
                        <span id="summary-property-category" class="text-gray-500 capitalize font-semibold pl-4 ">
                        </span>
                    </div>
                </div>
            @endif
            @if (in_array($type, ['tree-cutting-permits', 'transport-permit']))
                <div class="relative overflow-x-auto mt-12">


                    <div class="relative overflow-x-auto border">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-white uppercase bg-gray-500 border">
                                <tr>
                                    @if ($type === 'tree-cutting-permits')
                                        <th scope="col" class="px-6 py-3">Species</th>
                                        <th scope="col" class="px-6 py-3">No.</th>
                                        <th scope="col" class="px-6 py-3">Location</th>
                                        <th scope="col" class="px-6 py-3">Date Applied</th>
                                    @elseif($type === 'transport-permit')
                                        <th scope="col" class="px-6 py-3">Species</th>
                                        <th scope="col" class="px-6 py-3">No.</th>
                                        <th scope="col" class="px-6 py-3">Destination</th>
                                        <th scope="col" class="px-6 py-3">Date of Transport</th>
                                        <th scope="col" class="px-6 py-3">Date Applied</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody id="table-body" class="font-medium capitalize">
                                <!-- display the permit details here-->
                            </tbody>
                        </table>
                    </div>

                </div>
            @endif --}}

    </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const fileId = {!! json_encode($fileId) !!};
            const includePermit = true; // Set this based on your requirements

            const url = `/api/files/${fileId}?includePermit=${includePermit}`;
            try {
                const response = await fetch(url);

                if (!response.ok) throw new Error("You failed to fetch the data and permit");

                const data = await response.json();

                if (data.success) {
                    document.getElementById('summary-file-name').innerHTML = data.file.file_name;
                    document.getElementById('summary-name-of-client').innerHTML = data.permit.name_of_client;
                    document.getElementById('summary-office-source').innerHTML = data.file.office_source;
                    document.getElementById('summary-classification').innerHTML = data.file.classification;
                } else {
                    console.error('API Error:', data.message); // Log the error if the API call failed
                }
            } catch (error) {
                console.error("Error fetching data:", error); // Log any errors that occur
            } finally {
                // Any final operations can be performed here
            }
        });
    </script>
@endsection
