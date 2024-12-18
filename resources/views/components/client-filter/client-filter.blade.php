<div id="template-container" class="space-y-6 overflow-auto h-[calc(100vh-100px)] ">
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    {{-- <div class="relative">
        <div class="flex gap-3 fixed bg-white p-4 w-full">
            <input type="text" id="species-filter"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="John" required />
            <input type="text" id="location-filter"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="John" required />
            <input type="number" id="number-trees-filter"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="John" required />
            <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 focus:outline-none">Filter</button>
        </div>

    </div> --}}

    <div id="make-search-display"
        class="h-full w-full gap-3 bg-white p-6 border border-gray-200 rounded-lg shadow flex justify-center items-center text-gray-500 font-bold text-2xl">
        <h1 class="">Make a Search </h1>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd"
                d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                clip-rule="evenodd" />
        </svg>


    </div>
</div>


<!--tree cutting-->
<template id="tree-cutting-template">
    <div class="template-content bg-white rounded-lg shadow-md p-6">
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
                <strong>Client Name:</strong> <span id="name_of_client"></span>
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
        <div class="flex justify-end gap-2 p-3">
            <!--button here -->
            <a
                class="view-link text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                View
            </a>

            <a href="/api/files/download/${fileId}" target="_blank"
                class="download-link text-white bg-[#4a983b] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z"
                        clip-rule="evenodd" />
                    <path
                        d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                </svg>
                Download
            </a>
        </div>
    </div>
</template>
<!--chainsaw reg-->
<template id="chainsaw-registration-template">
    <div class="template-content bg-white rounded-lg shadow-md p-6">
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
                <strong>Client Name:</strong> <span id="name_of_client"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Office Source:</strong> <span id="office_source"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Location:</strong> <span id="location"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Serial Number:</strong> <span id="serial_number"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Date Applied:</strong> <span id="date_applied"></span>
            </p>
        </div>
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 p-3">
            <!--button here -->
            <a
                class="view-link text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                View
            </a>

            <a href="/api/files/download/${fileId}" target="_blank"
                class="download-link text-white bg-[#4a983b] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z"
                        clip-rule="evenodd" />
                    <path
                        d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                </svg>
                Download
            </a>
        </div>
    </div>
</template>

<!--plantation-->
<template id="plantation-template">
    <div class="template-content bg-white rounded-lg shadow-md p-6">
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
                <strong>Client Name:</strong> <span id="name_of_client"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Office Source:</strong> <span id="office_source"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Location:</strong> <span id="location"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Number of Trees:</strong> <span id="number_of_trees"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Date Applied:</strong> <span id="date_applied"></span>
            </p>
        </div>
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 p-3">
            <!--button here -->
            <a
                class="view-link text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                View
            </a>

            <a href="/api/files/download/${fileId}" target="_blank"
                class="download-link text-white bg-[#4a983b] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z"
                        clip-rule="evenodd" />
                    <path
                        d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                </svg>
                Download
            </a>
        </div>
    </div>
</template>
<!-- transport -->
<template id="transport-template">
    <div class="template-content bg-white rounded-lg shadow-md p-6">
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
                <strong>Client Name:</strong> <span id="name_of_client"></span>
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
                            <th scope="col" class="px-6 py-3">Destination</th>
                            <th scope="col" class="px-6 py-3">Date Of Transport</th>
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
        <div class="flex justify-end gap-2 p-3">
            <!--button here -->
            <a
                class="view-link text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                View
            </a>

            <a href="/api/files/download/${fileId}" target="_blank"
                class="download-link text-white bg-[#4a983b] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z"
                        clip-rule="evenodd" />
                    <path
                        d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                </svg>
                Download
            </a>
        </div>
    </div>
</template>
<!--land title-->
<template id="land-template">
    <div class="template-content bg-white rounded-lg shadow-md p-6">
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
                <strong>Client Name:</strong> <span id="name_of_client"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Office Source:</strong> <span id="office_source"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Location:</strong> <span id="location"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Lot Number:</strong> <span id="lot_number"></span>
            </p>
            <p class="mb-3 font-normal text-gray-700">
                <strong>Property Category:</strong> <span id="property_category"></span>
            </p>
        </div>
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 p-3">
            <!--button here -->
            <a
                class="view-link text-white bg-[#3b5998] hover:bg-[#3b5998]/90 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                        clip-rule="evenodd" />
                </svg>
                View
            </a>

            <a href="/api/files/download/${fileId}" target="_blank"
                class="download-link text-white bg-[#4a983b] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-[#3b5998]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#3b5998]/55 me-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M9.75 6.75h-3a3 3 0 0 0-3 3v7.5a3 3 0 0 0 3 3h7.5a3 3 0 0 0 3-3v-7.5a3 3 0 0 0-3-3h-3V1.5a.75.75 0 0 0-1.5 0v5.25Zm0 0h1.5v5.69l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72V6.75Z"
                        clip-rule="evenodd" />
                    <path
                        d="M7.151 21.75a2.999 2.999 0 0 0 2.599 1.5h7.5a3 3 0 0 0 3-3v-7.5c0-1.11-.603-2.08-1.5-2.599v7.099a4.5 4.5 0 0 1-4.5 4.5H7.151Z" />
                </svg>
                Download
            </a>
        </div>
    </div>
</template>
