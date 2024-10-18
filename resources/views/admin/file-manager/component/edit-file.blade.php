<div id="edit-file" class="flex items-center justify-center">
    <div class="w-full max-w-3xl p-6">
        <!-- Heading for Edit File -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit File</h2>

        <form method="POST" class="space-y-4">
            @csrf

            <!-- Flex container for left and right input sections -->
            <div class="flex space-x-4">

                <!-- Left Section -->
                <div class="flex-1">
                    <!-- Office Source Field -->
                    <div>
                        <label for="edit-office_source" class="block mb-2 text-sm font-medium text-red-700">Office
                            Source</label>
                        <input type="text" id="edit-office_source" name="office_source"
                            class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                            placeholder="Enter office Source" required>
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid input!
                        </p>
                    </div>

                    <!-- Category Field -->
                    <div>
                        <label for="edit-category" class="block mb-2 text-sm font-medium text-red-700">Category</label>
                        <select id="edit-category" name="category"
                            class="bg-red-50 border border-red-500 text-red-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                            required>
                            <option value="">Select a Category</option>
                            <option value="incoming">Incoming</option>
                            <option value="outgoing">Outgoing</option>
                            <!-- Add more categories as needed -->
                        </select>
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid input!
                        </p>
                    </div>

                    <!-- Classification Field -->
                    <div>
                        <label for="edit-classification"
                            class="block mb-2 text-sm font-medium text-red-700">Classification</label>
                        <input type="text" id="edit-classification" name="classification"
                            class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                            placeholder="Enter Classification" required>
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid input!
                        </p>
                    </div>

                    <!-- Status Field -->
                    <div>
                        <label for="edit-status" class="block mb-2 text-sm font-medium text-red-700">Status</label>
                        <input type="text" id="edit-status" name="status"
                            class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                            placeholder="Enter Status" required>
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid input!
                        </p>
                    </div>
                </div>

                <!-- Right Section -->

                <div class="flex-1">
                    <!-- Name of Client Field -->
                    @if ($type == 'tree-cutting-permits')
                        <div>
                            <label for="edit-client_name" class="block mb-2 text-sm font-medium text-red-700">Client
                                Name</label>
                            <input type="text" id="edit-client_name" name="client_name"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter client name" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!
                            </p>
                        </div>

                        <!-- No. of Trees / Species Field -->
                        <div>
                            <label for="edit-number_of_trees" class="block mb-2 text-sm font-medium text-red-700">No. of
                                Trees / Species</label>
                            <input type="text" id="edit-number_of_trees" name="number_of_trees"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter number of trees" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!
                            </p>
                        </div>

                        <!-- Location Field -->
                        <div>
                            <label for="edit-location"
                                class="block mb-2 text-sm font-medium text-red-700">Location</label>
                            <input type="text" id="edit-location" name="location"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter Location" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!
                            </p>
                        </div>

                        <!-- Date Applied Field -->
                        <div>
                            <label for="edit-date_applied" class="block mb-2 text-sm font-medium text-red-700">Date
                                Applied</label>
                            <input type="date" id="edit-date_applied" name="date_applied"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!
                            </p>
                        </div>
                    @elseif ($type == 'chainsaw-registration')
                        <!-- Client Name Field -->
                        <div>
                            <label for="edit-client_name" class="block mb-2 text-sm font-medium text-red-700">Client
                                Name</label>
                            <input type="text" id="edit-client_name" name="name_of_client"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter client name" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!</p>
                        </div>

                        <!-- Location Field -->
                        <div>
                            <label for="edit-location"
                                class="block mb-2 text-sm font-medium text-red-700">Location</label>
                            <input type="text" id="edit-location" name="location"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter location" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!</p>
                        </div>

                        <!-- Serial Number Field -->
                        <div>
                            <label for="edit-serial_number" class="block mb-2 text-sm font-medium text-red-700">Serial
                                Number</label>
                            <input type="text" id="edit-serial_number" name="serial_number"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                placeholder="Enter serial number" required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!</p>
                        </div>

                        <!-- Date Applied Field -->
                        <div>
                            <label for="edit-date_applied" class="block mb-2 text-sm font-medium text-red-700">Date
                                Applied</label>
                            <input type="date" id="edit-date_applied" name="date_applied"
                                class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5"
                                required>
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">Please!</span> Enter valid
                                input!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button type="submit"
                    class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>



<script>
    document.body.addEventListener('click', function(event) {
        if (event.target.matches('.edit-button')) {
            toggleSections(true);
            const fileId = event.target.dataset.fileId; // Get the file ID
            console.log('This is file ID:', fileId);

            // Call the function to fetch the file data using the retrieved file ID
            fetchFileData(fileId);
        }
    });

    // This script fetches file data when an edit button is clicked
    function fetchFileData(fileId) {
        fetch(`/api/files/${fileId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const file = data.file; // File data
                    const permit = data.permit; // Permit details

                    // Common fields for all permits
                    document.getElementById('edit-office_source').value = file.office_source || '';
                    document.getElementById('edit-category').value = file.category || '';
                    document.getElementById('edit-classification').value = file.classification || '';
                    document.getElementById('edit-status').value = file.status || '';

                    // Check the permit type and populate fields accordingly
                    switch (file.permit_type) {
                        case 'tree-cutting-permits':
                            document.getElementById('edit-client_name').value = permit.name_of_client || '';
                            document.getElementById('edit-number_of_trees').value = permit.number_of_trees || '';
                            document.getElementById('edit-location').value = permit.location || '';
                            document.getElementById('edit-date_applied').value = permit.date_applied || '';
                            break;

                        case 'chainsaw-registration':
                            document.getElementById('edit-client_name').value = permit.name_of_client || '';
                            document.getElementById('edit-location').value = permit.location || '';
                            document.getElementById('edit-serial_number').value = permit.serial_number || '';
                            document.getElementById('edit-date_applied').value = permit.date_applied || '';
                            break;

                            // Add cases for other permit types, e.g. tree-plantation, tree-transport-permits, etc.

                        default:
                            console.error('Unknown permit type:', file.permit_type);
                    }

                    console.log(file.permit_type);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
    }
</script>
