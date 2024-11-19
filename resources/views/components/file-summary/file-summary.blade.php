<!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
<!-- When there is no desire, all things are at peace. - Laozi -->

<div id="file-summary-div" class="p-4 overflow-hidden">
    <div id="child-file-summary-div">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-700">File Summary</h2> {{-- add summary --}}
            <button type="button" id="close-summary-btn"
                class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                <i class='bx bx-x bx-md'></i>
            </button>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">File Name:</span>
                <span id="summary-file-name" class="text-gray-600 font-semibold pl-4 "> </span>
            </div>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Name of Client:</span>
                <span id="summary-client-name" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
            </div>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <div
                class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                <span class="text-sm font-medium text-gray-900">Location:</span>
                <span id="summary-location" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
            </div>
        </div>

        <!-- Conditional fields based on permit type -->
        @if (in_array($type, ['tree-cutting-permits', 'tree-plantation', 'tree-transport-permits']))
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Number of Trees:</span>
                    <span id="summary-number-of-trees" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif

        @if ($type == 'chainsaw-registration')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Serial Number:</span>
                    <span id="summary-serial-number" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif

        @if ($type == 'tree-transport-permits')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Species:</span>
                    <span id="summary-species" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Destination:</span>
                    <span id="summary-destination" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif

        @if ($type == 'land-titles')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Lot Number:</span>
                    <span id="summary-lot-number" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Property Category:</span>
                    <span id="summary-property-category" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif

        @if ($type != 'land-titles')
            <div class="relative z-0 w-full mb-5 group">
                <div
                    class="py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <span class="text-sm font-medium text-gray-900">Date Applied:</span>
                    <span id="summary-date-applied" class="text-gray-600 capitalize font-semibold pl-4 "> </span>
                </div>
            </div>
        @endif




        <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white">
                    Tree Specifications
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Color
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            $2999
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>


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
    async function fetchFileDetails(fileId) {


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
                        const input = document.getElementById(`edit-${idSelector}`);

                        if (input) {
                            input.value = value;
                        }
                    });

                    if (data.permit.details) {
                        const details = data.permit.details;

                        for (let index = 0; index < details.length; index++) {
                            const detail = details[index];
                            editSpecification();

                            // Find the newly cloned delete button


                            Object.entries(detail).forEach(([key, value]) => {
                                // Get the delete button based on the data-detail-id
                                const deleteBtn = document.querySelector(
                                    `[data-detail-id="${key}[${index}]"]`);

                                // Get the input based on the id
                                const input = document.querySelector(`[id="${key}[${index}]"]`);

                                // If the input and deleteBtn exist, set their values
                                if (input) {
                                    input.value = value; // Set value for the input
                                }

                                if (deleteBtn) {

                                    deleteBtn.setAttribute('data-detail-id',
                                        value);
                                }
                            });

                        }
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
