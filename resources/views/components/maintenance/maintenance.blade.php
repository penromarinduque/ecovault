<!-- Be present above all else. - Naval Ravikant -->
<div id="addButterflyModal" class="flex justify-center items-center z-50">
    <div class="p-6 rounded bg-white border border-gray-300 w-9/12 space-y-5">
        <h2 class="text-2xl text-gray-700 font-bold mb-6">Add New Butterfly</h2>

        <form id="butterflyForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Scientific Name -->
                <div>
                    <label for="newScientificName" class="block font-medium text-gray-700 mb-1">Scientific Name</label>
                    <input type="text" name="scientific_name" id="newScientificName" placeholder="Add Scientific Name"
                        class="w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Common Name -->
                <div>
                    <label for="newCommonName" class="block font-medium text-gray-700 mb-1">Common Name</label>
                    <input type="text" name="common_name" id="newCommonName" placeholder="Add Common Name"
                        class="w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Family -->
                <div>
                    <label for="newFamily" class="block font-medium text-gray-700 mb-1">Family</label>
                    <input type="text" name="family" id="newFamily" placeholder="Add Family"
                        class="w-full p-2 border border-gray-300 rounded-lg" required />
                </div>

                <!-- Genus -->
                <div>
                    <label for="newGenus" class="block font-medium text-gray-700 mb-1">Genus</label>
                    <input type="text" name="genus" id="newGenus" placeholder="Add Genus"
                        class="w-full p-2 border border-gray-300 rounded-lg" />
                </div>
            </div>

            <!-- Description -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4">
                <div class="">
                    <label for="newDescription" class="block font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="newDescription" placeholder="Add Description"
                        class="w-full p-2 border border-gray-300 rounded-lg" required></textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="w-full p-5 flex gap-4">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Add
                    Butterfly</button>
                <a href="{{ route('show.maintenance.table') }}"
                    class="px-4 py-2 bg-none border border-gray-400 text-gray-600 font-medium rounded-lg hover:bg-slate-700 hover:text-white">View
                    All
                    Species</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("butterflyForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this); // Collect input values from the form

        fetch('/butterfly/add', {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content // CSRF token
                },
                body: formData, // Send the collected form data
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to upload butterfly");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.reset(); // Reset form inputs
                    showToast({
                        type: 'success',
                        message: 'Success! The maintenance is complete.',

                    });
                } else {
                    showToast({
                        type: ' ',
                        message: 'Failed to add butterfly. Please check your input.',
                    });
                }
            })
            .catch(error => {
                console.error("Error adding butterfly:", error);
                showToast({
                    type: 'danger',
                    message: 'Failed to add butterfly due to a server error.',
                });
            });
    });
</script>
