@if ($type == 'tree-cutting-permits' || $type == 'transport-permit')
    <section class="col-span-2 w-full mt-10">
        <!-- Main modal -->
        <div class="overflow-y-auto overflow-x-hidden">
            <div class="bg-transparent">
                <div id="edit-specification-container" class="grid grid-cols-1 gap-y-10 gap-x-10">
                    <template id="edit-specification-template" class="hidden">
                        <div class="file-specification-box col-span-1 border border-gray-500 rounded-md">
                            <div class="flex items-center justify-between p-3">
                                <h2 id="box-number" class="text-lg font-bold text-gray-700 m-2">Specification 1
                                </h2>
                                <button type="button" id="close-edit-specification"
                                    class="end-2.5 m-2 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <button type="button" id="delete-specification"
                                    class="hidden inline-flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mt-2">
                                    <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Delete
                                </button>

                            </div>
                            <div class="p-4 pt-0 grid grid-cols-2 gap-x-4 w-full font-medium">
                                <input type="hidden" id="id[]" data-edit="id[]" name="id[]" value="">

                                <div class="my-4">
                                    <label for="species[]"
                                        class="block mb-2 text-sm font-medium text-gray-700">Species</label>
                                    <input type="text" id="species[]" data-edit="species[]" name="species[]"
                                        placeholder="Enter Species"
                                        class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                        autocomplete="off" required>
                                </div>
                                <div class="my-4">
                                    <label for="number_of_trees[]"
                                        class="block mb-2 text-sm font-medium text-gray-700">No.
                                        of Trees</label>
                                    <input type="number" id="number_of_trees[]" data-edit="number_of_trees[]"
                                        name="number_of_trees[]"
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
                                        <label for="location[]"
                                            class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                                        <input type="text" id="location[]" data-edit="location[]" name="location[]"
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
                                        <label for="date_of_transport[]"
                                            class="block mb-2 text-sm font-medium text-gray-700">Date of
                                            Transport</label>
                                        <input type="date" id="date_of_transport[]"
                                            data-edit="date_of_transport[]"sport name="date_of_transport[]"
                                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                        block w-full p-2.5 
                                        focus:border-green-500 focus:ring-green-500 
                                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                            autocomplete="off" required>
                                    </div>
                                    <div class="my-4">
                                        <label for="destination[]"
                                            class="block mb-2 text-sm font-medium text-gray-700">Destination</label>
                                        <input type="text" id="destination[]" data-edit="destination[]"
                                            name="destination[]"
                                            class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded-lg 
                                    block w-full p-2.5 
                                    focus:border-green-500 focus:ring-green-500 
                                    required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                                    valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                            autocomplete="off" required placeholder="Enter destination">
                                    </div>
                                @endif
                                <div class="my-4">
                                    <label for="date_applied[]"
                                        class="block mb-2 text-sm font-medium text-gray-700">Date
                                        Applied</label>
                                    <input type="date" id="date_applied[]" data-edit="date_applied[]"
                                        name="date_applied[]"
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
        let editIdChanger = 0;
        const maxSpecifications = 20; // Set the limit for the number of clones

        document.getElementById('add-edit-specification').addEventListener('click', function() {
            editSpecification();
        });

        function editSpecification() {
            const existingSpecifications = document.querySelectorAll('.file-specification-box').length;

            if (existingSpecifications >= maxSpecifications) {
                alert(`You can only add up to ${maxSpecifications} specifications.`);
                return;
            }
            let id = null;
            createAndAppendClones(existingSpecifications);
        }

        function createAndAppendClones(existingSpecifications) {
            const clone = document.getElementById('edit-specification-template').content.cloneNode(true);

            // Set unique IDs and data-edit attributes
            const inputs = clone.querySelectorAll('input[id]');
            inputs.forEach(input => {
                let currentId = input.getAttribute('id'); // Get the current ID
                if (currentId.includes("[]")) { // Check if it contains "[]"
                    const updatedId = currentId.replace("[]",
                        `[${editIdChanger}]`); // Replace "[]" with dynamic index
                    input.setAttribute('id', updatedId); // Update the ID
                    const label = clone.querySelector(`label[for='${currentId}']`);
                    if (label) {
                        label.setAttribute('for', updatedId);
                    }
                }
            });
            // Set the dynamic ID for the specification container
            const specificationDiv = clone.querySelector('.file-specification-box');
            specificationDiv.id =
                `file-specification-box-${editIdChanger}`;

            // Update the label with the current specification number
            const boxNumber = clone.querySelector('#box-number');
            if (boxNumber) {
                boxNumber.id = `box-number-${editIdChanger}`;
                boxNumber.innerText = `Specification ${existingSpecifications + 1}`;
            }

            const closeBtn = clone.querySelector('#close-edit-specification');
            if (closeBtn) {

                closeBtn.id = `close-specification-${editIdChanger}`;
                closeBtn.addEventListener('click', function() {
                    specificationDiv.remove();
                    renumberSpecifications();
                });
            }
            // Add event listener for the close button
            const deleteBtn = clone.querySelector('#delete-specification');
            if (deleteBtn) {
                // deleteBtn.setAttribute('data-detail-id', `id[${editIdChanger}]`);
                deleteBtn.id = `delete-specification-${editIdChanger}`;
                deleteBtn.addEventListener('click', function() {
                    specificationDiv.remove();
                    renumberSpecifications();
                });
            }

            // Append the cloned template to the container
            document.getElementById('edit-specification-container').appendChild(clone);

            // Increment the editIdChanger for next clone
            editIdChanger++;
        }
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
