@if ($type == 'tree-cutting-permits' || $type == 'tree-transport-permits')
    <section class="col-span-2 w-full mt-10">
        <!-- Main modal -->
        <div class="overflow-y-auto overflow-x-hidden">

            <div class="bg-transparent">
                <div id="file-specification-container" class="grid grid-cols-2 gap-y-10 gap-x-10">
                    <template id="file-specification-template">
                        <div class="file-specification-box col-span-1 border border-gray-500 rounded-md">
                            <div class="flex items-center justify-between">
                                <h2 id="box-number" class="text-lg font-bold text-gray-700 m-2">Specification 1
                                </h2>
                                <button type="button" id="close-specification"
                                    class="end-2.5 m-2 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="p-4 pt-0 grid grid-cols-2 gap-x-4 w-full">
                                <div class="my-4">
                                    <label for="species" id="label-species"
                                        class="block mb-2 text-sm font-medium text-gray-700">Species</label>
                                    <input type="text" id="species" name="species[]" placeholder="Enter Species"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                </div>
                                <div class="my-4">
                                    <label for="number_of_trees" id="label-number_of_trees"
                                        class="block mb-2 text-sm font-medium text-gray-700">No.
                                        of Trees</label>
                                    <input type="number" id="number_of_trees" name="number_of_trees[]"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required placeholder="Enter number of trees">
                                </div>
                                <!-- location for tree cutting permits-->
                                @if ($type == 'tree-cutting-permits')
                                    <div class="my-4">
                                        <label for="location" id="label-location"
                                            class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                        <input type="text" id="location" name="location[]"
                                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                            autocomplete="off" required placeholder="Enter Location">
                                    </div>
                                @else
                                    <!--destination and date of for transport permits-->
                                    <div class="my-4">
                                        <label for="date_of_transport"
                                            class="block mb-2 text-sm font-medium text-gray-700">Date of
                                            Transport</label>
                                        <input type="date" id="date_of_transport" name="date_of_transport[]"
                                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                        block w-full p-2.5 
                                        focus:border-green-500 focus:ring-green-500 
                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="my-4">
                                        <label for="destination"
                                            class="block mb-2 text-sm font-medium text-gray-700">Destination</label>
                                        <input type="text" id="destination" name="destination"
                                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                            autocomplete="off" required placeholder="Enter destination">
                                    </div>
                                @endif
                                <div class="my-4">
                                    <label for="date_applied" id="label-date_applied"
                                        class="block mb-2 text-sm font-medium text-gray-700">Date
                                        Applied</label>
                                    <input type="date" id="date_applied" name="date_applied[]"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </section>

    <script>
        let idNameChanger = 0;

        document.getElementById('add-file-specification').addEventListener('click', function() {
            const clone = document.getElementById('file-specification-template').content.cloneNode(true);
            const inputs = ['species', 'number_of_trees', 'location', 'date_applied'];

            idNameChanger++;

            // Assign IDs and names to each input element dynamically
            inputs.forEach(inputId => {
                const inputElement = clone.querySelector(`#${inputId}`);
                const labelElement = clone.querySelector(
                    `#label-${inputId}`); // Select label by prefixed ID

                if (inputElement && labelElement) {
                    const uniqueId = `${inputId}-${idNameChanger}`;

                    inputElement.id = uniqueId;
                    //inputElement.name = uniqueId;
                    labelElement.htmlFor = uniqueId;
                    labelElement.id = `label-${uniqueId}`;
                }
            });

            // Set the dynamic ID for the specification container
            const specificationDiv = clone.querySelector('.file-specification-box');
            specificationDiv.id = `file-specification-box-${idNameChanger}`;

            // Display the current number of specifications in the label
            const boxNumber = clone.querySelector('#box-number');
            if (boxNumber) {
                boxNumber.id = `box-number-${idNameChanger}`;
                boxNumber.innerText =
                    `Specification ${document.querySelectorAll('.file-specification-box').length + 1}`;
            }

            // Close button logic to remove and renumber remaining specifications
            const closeBtn = clone.querySelector('#close-specification');
            if (closeBtn) {
                closeBtn.id = `close-specification-${idNameChanger}`;
                closeBtn.addEventListener('click', function() {
                    specificationDiv.remove();
                    renumberSpecifications();
                });
            }

            // Append the cloned template to the container
            document.getElementById('file-specification-container').appendChild(clone);
        });

        // Function to renumber specifications after deletion
        function renumberSpecifications() {
            const specifications = document.querySelectorAll('.file-specification-box');
            specifications.forEach((spec, number) => {
                const boxNumber = spec.querySelector('[id^="box-number"]');
                if (boxNumber) {
                    boxNumber.innerText = `Specification ${number + 1}`;
                }
            });
        }
    </script>
@endif
