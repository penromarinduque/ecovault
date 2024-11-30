<!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
<!-- When there is no desire, all things are at peace. - Laozi -->

<div id="file-summary-div" class="p-4 overflow-hidden">
    <div id="child-file-summary-div">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-700">File Summary <span
                    class="font-medium text-slate-600 pl-6">({{ ucwords(str_replace('-', ' ', $type ?: $record)) }})</span>
            </h2>
            {{-- add summary --}}
            <button type="button" id="close-upload-btn" aria-controls="section-close-all"
                class="close-all-btn toggle-btn hover:bg-red-200 p-3 rounded-full text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-lg font-medium text-gray-800">File Name:</span>
                <span id="summary-file-name" class="text-gray-600 font-semibold pl-4 "> </span>
            </div>
        </div>
        @if (!$record)
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Name of Client:</span>
                    <span id="summary-name-of-client" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @elseif($record)
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Office Source:</span>
                    <span id="summary-office-source" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Classification:</span>
                    <span id="summary-classification" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif
        @if ($type == 'tree-plantation')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Number of Trees:</span>
                    <span id="summary-number-of-trees" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif
        @if (in_array($type, ['chainsaw-registration', 'tree-plantation', 'land-titles']))
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Location:</span>
                    <span id="summary-location" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif
        @if ($type == 'chainsaw-registration' || $type == 'tree-plantation')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Date Applied:</span>
                    <span id="summary-date-applied" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif
        <!-- Conditional fields based on permit type -->

        @if ($type == 'chainsaw-registration')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Serial Number:</span>
                    <span id="summary-serial-number" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif


        @if ($type == 'land-titles')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Lot Number:</span>
                    <span id="summary-lot-number" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-lg text-gray-800 bg-transparent border-0 border-b-2 border-gray-400 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-lg font-medium text-gray-800">Property Category:</span>
                    <span id="summary-property-category" class="text-gray-600 capitalize font-semibold pl-4 ">
                    </span>
                </div>
            </div>
        @endif
        @if (in_array($type, ['tree-cutting-permits', 'tree-transport-permits']))
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
                                @elseif($type === 'tree-transport-permits')
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
        @endif

    </div>
    <div id="summary-loading" class="relative overflow-hidden flex justify-center items-center h-full">
        <div role="status" class="absolute">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only"> </span>
        </div>
    </div>
</div>



<script>
    // Fetches file data dynamically
    async function fetchFileSummary(fileId) {


        let includePermit = {!! json_encode($includePermit ?? '') !!};

        //includePermit boolean if file have permit Y/N

        const url = `/api/files/${fileId}?includePermit=${includePermit}`;
        try {
            const response = await fetch(url);

            if (!response.ok) throw new Error("You failed to fetch the data and permit");

            const data = await response.json();


            if (data.success) {

                const editForm = document.getElementById('edit-file-form');
                editForm.dataset.fileId = fileId; // Set fileId in data-file-id
                // Handle `file` properties
                Object.entries(data.file).forEach(([key, value]) => {

                    const idSelector = key.replace(/_/g, '-'); // Prepare the class name selector
                    // Select all elements with the corresponding class and update their value
                    const span = document.getElementById(`summary-${idSelector}`);
                    if (span) {
                        span.innerHTML = value;
                    }
                });

                // Handle `permit` properties (if it exists)
                if (data.permit) {
                    Object.entries(data.permit).forEach(([key, value]) => {
                        const idSelector = key.replace(/_/g, '-'); // Prepare the class name selector

                        // Select all elements with the corresponding class and update their value
                        const input = document.getElementById(`summary-${idSelector}`);

                        if (input) {
                            input.innerHTML = value;
                        }
                    });

                    if (data.permit.details) {
                        const details = data.permit.details;

                        const tableBody = document.getElementById('table-body');

                        tableBody.innerHTML = '';
                        details.forEach((detail, index) => {
                            let row = '';

                            if (type === 'tree-cutting-permits') {
                                row = `
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-6 py-3">${detail.species || ''}</td>
                                        <td class="px-6 py-3">${detail.number_of_trees || ''}</td>
                                        <td class="px-6 py-3">${detail.location || ''}</td>
                                        <td class="px-6 py-3">${detail.date_applied || ''}</td>
                                    </tr>
                                `;
                            } else if (type === 'tree-transport-permits') {
                                row = `
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-6 py-3">${detail.species || ''}</td>
                                        <td class="px-6 py-3">${detail.number_of_trees || ''}</td>
                                        <td class="px-6 py-3">${detail.destination || ''}</td>
                                        <td class="px-6 py-3">${detail.date_of_transport || ''}</td>
                                        <td class="px-6 py-3">${detail.date_applied || ''}</td>
                                    </tr>
                                `;
                            }
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                }
            } else {
                console.error('API Error:', data.message); // Log the error if the API call failed
            }
        } catch (error) {
            console.error("Error fetching data:", error); // Log any errors that occur
        } finally {

        }

    }
</script>
