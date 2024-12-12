<div id="template-container" class="space-y-6">
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
</div>


<!--tree cutting-->
<template id="tree-cutting-template">
    <div class=" bg-white rounded-lg shadow-md p-6">
        <!-- Card Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">File Information</h2>
            <span id="created_at" class="text-sm text-gray-500">Uploaded: 10 Dec 2024</span>
        </div>

        <!-- Card Content -->
        <div class="mb-4">
            <p class="mb-3 font-normal text-gray-700">
                <strong>File Name:</strong> <span id="file_name"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Office Source:</strong> <span id="office_source"></span>
            </p>
        </div>
        <div class="relative overflow-x-auto mt-12">


            <div class="relative overflow-x-auto border">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-white uppercase bg-gray-500 border">
                        <tr>
                            <th scope="col" class="px-6 py-3">Species</th>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Location</th>
                            <th scope="col" class="px-6 py-3">Date Applied</th>
                        </tr>
                    </thead>
                    <tbody class="details-table" data-file-id="">
                        <!-- Table rows will be inserted dynamically here -->
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2">
            <!--button here -->
        </div>
    </div>
</template>
