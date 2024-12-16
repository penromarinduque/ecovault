@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <x-modal.file-modal />
    <div class="grid grid-cols-4 gap-6">
        <section class="col-span-1">

            <div class="space-y-6 bg-white p-6 border border-gray-200 rounded-lg shadow">
                <!-- Combined Form -->
                <form id="filter-form" class="max-w-md mx-auto space-y-6 font-medium">
                    @csrf
                    <label for="client-search" class="mb-2 text-sm font-medium  sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="client-search" name="client-search"
                            class=" bg-gray-50 border border-gray-300 text-green-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-3 ps-10 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                            placeholder="Search name of client" required autocomplete="off" />

                    </div>

                    <select id="select-permit-type" name="permit_type" required
                        class=" bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-3 capitalize
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100">
                        <option value="" disabled selected>Select permit type</option>
                        <!-- Add your options here -->
                    </select>
                    <select id="municipality" name="municipality" required
                        class=" bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-3 capitalize
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100">
                        <option value="" disabled selected hidden>Select municipality</option>

                        <!-- Add your options here -->
                    </select>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex items-center ps-4 border border-gray-500 rounded">
                            <input type="checkbox" id="archived-checkbox" name="archived" value=""
                                class=" text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="archived-checkbox"
                                class="w-full ms-2 text-sm font-medium text-gray-900">Archived</label>
                        </div>

                        <div>
                            <select id="classification" name="classification"
                                class="bg-gray-50 border border-gray-500 text-gray-900 placeholder-gray-700 text-sm rounded 
                        block w-full p-2.5 
                        focus:border-green-500 focus:ring-green-500 
                        required:border-gray-500 required:ring-gray-500  required:text-gray-500 required:placeholder:text-gray-500
                        valid:border-green-500 valid:ring-green-500 valid:text-green-800 valid:bg-green-100"
                                required>
                                <option value="" disabled selected hidden>Classification</option>
                                <option value="highly-technical">Highly Technical</option>
                                <option value="simple">Simple</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-sm text-sm px-4 py-2">Search</button>
                </form>


                <!-- Display filtered data here -->
                <div id="files-list"></div>

            </div>

        </section>

        <!--second section-->
        <section class="col-span-3">

            <div class="w-full">
                {{-- <form class="grid grid-cols-2">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search..." required />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                    </div>
                </form> --}}
            </div>

            @component('components.client-filter.client-filter', [
                //Enter here for passing variable(future purposes)
            ])
            @endcomponent

        </section>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', () => {
            permitType();
            municipalities();
            const filterForm = document.getElementById('filter-form');
            const makeSearchDisplay = document.getElementById('make-search-display');
            filterForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                const templateContainer = document.querySelectorAll('.template-content');

                templateContainer.forEach(template => {
                    template.remove();
                });


                const formData = new FormData(filterForm);
                const municipality = formData.get('municipality');
                const clientSearch = formData.get('client-search');
                const permitType = formData.get('permit_type');
                const archivedCheckbox = document.getElementById('archived-checkbox');
                const archived = archivedCheckbox.checked; // True if checked, false if unchecked
                const classification = formData.get('classification');
                filterForm.classList.add('opacity-50', 'pointer-events-none');
                try {
                    // Pass form data as query parameters
                    const response = await fetch(`/files/filter?` + new URLSearchParams({
                        'client-search': clientSearch,
                        'permit_type': permitType,
                        'archived': archived,
                        'classification': classification,
                        'municipality': municipality,
                    }));
                    console.log(classification)
                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }

                    const data = await response.json();
                    const elements = document.querySelectorAll('.template-content');

                    if (data && data.data.length > 0) {
                        makeSearchDisplay.classList.add('hidden');
                    } else {
                        makeSearchDisplay.classList.remove('hidden');
                        showToast({
                            type: 'default',
                            message: 'No results found. Please try again with different keywords or filters.',

                        });
                    }
                    // Handle response data
                    data.data.forEach(file => {
                        switch (file.permit_type) {
                            case 'tree-cutting-permits':
                                const treeCuttingTemplate = document.getElementById(
                                    'tree-cutting-template');
                                const treeCuttingClone = document.importNode(treeCuttingTemplate
                                    .content,
                                    true);

                                // Fill the template with values from the file object
                                Object.entries(file).forEach(([key, value]) => {
                                    const element = treeCuttingClone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent = value;
                                    }
                                });

                                // Assign a unique class or data attribute to the tbody using file.id
                                const tableBody = treeCuttingClone.querySelector('tbody');
                                tableBody.setAttribute('data-file-id', file
                                    .id); // Use data attribute for unique identification

                                setupLinks(treeCuttingClone, file.id);

                                // Append the cloned template to the container
                                document.getElementById('template-container').appendChild(
                                    treeCuttingClone);

                                // Loop through the details and add rows to the table for this specific file
                                file.details.forEach(detail => {
                                    let row = `<tr class="odd:bg-white even:bg-gray-100">
                    <td class="px-6 py-3">${detail.species || ''}</td>
                    <td class="px-6 py-3">${detail.number_of_trees || ''}</td>
                    <td class="px-6 py-3">${detail.location || ''}</td>
                    <td class="px-6 py-3">${detail.date_applied || ''}</td>
                </tr>`;
                                    // Insert the row into the correct table based on the file id
                                    const tableBody = document.querySelector(
                                        `[data-file-id="${file.id}"]`);
                                    if (tableBody) {
                                        tableBody.insertAdjacentHTML('beforeend', row);
                                    }
                                });
                                break;

                            case 'chainsaw-registration':
                                const chainsawTemplate = document.getElementById(
                                    'chainsaw-registration-template');
                                const chainsawClone = document.importNode(chainsawTemplate
                                    .content,
                                    true);
                                Object.entries(file).forEach(([key, value]) => {

                                    // Select elements inside the clone with matching IDs
                                    const element = chainsawClone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent =
                                            value; // Update the element with the value
                                    }

                                });
                                setupLinks(chainsawClone, file.id);

                                document.getElementById('template-container').appendChild(
                                    chainsawClone);
                                break;

                            case 'tree-plantation-registration':
                                const plantationTemplate = document.getElementById(
                                    'plantation-template');
                                const plantationClone = document.importNode(plantationTemplate
                                    .content, true);

                                Object.entries(file).forEach(([key, value]) => {
                                    const element = plantationClone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent = value;
                                    }
                                });

                                setupLinks(plantationClone, file.id);
                                document.getElementById('template-container').appendChild(
                                    plantationClone);

                                break;

                            case 'transport-permit':
                                const transportTemplate = document.getElementById(
                                    'transport-template');
                                const transportClone = document.importNode(transportTemplate
                                    .content, true);

                                Object.entries(file).forEach(([key, value]) => {
                                    const element = transportClone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent = value;
                                    }
                                });

                                const tbody = transportClone.querySelector('tbody');
                                tbody.setAttribute('data-file-id', file.id);
                                setupLinks(transportClone, file.id);
                                document.getElementById('template-container').appendChild(
                                    transportClone);
                                file.details.forEach(detail => {
                                    let row = `<tr class="odd:bg-white even:bg-gray-100">
                    <td class="px-6 py-3">${detail.species || ''}</td>
                    <td class="px-6 py-3">${detail.number_of_trees || ''}</td>
                    <td class="px-6 py-3">${detail.location || ''}</td>
                     <td class="px-6 py-3">${detail.date_of_transport || ''}</td>
                    <td class="px-6 py-3">${detail.date_applied || ''}</td>
                </tr>`;

                                    const tbody = document.querySelector(
                                        `[data-file-id="${file.id}"]`);

                                    if (tbody) {
                                        tbody.insertAdjacentHTML('beforeend', row);
                                    }

                                });
                                break;

                            case 'land-title':
                                const landTemplate = document.getElementById('land-template');
                                const landClone = document.importNode(landTemplate.content,
                                    true);

                                Object.entries(file).forEach(([key, value]) => {
                                    const element = landClone.querySelector(
                                        `[id="${key}"]`);
                                    if (element) {
                                        element.textContent = value;
                                    }
                                });
                                setupLinks(landClone, file.id);
                                document.getElementById('template-container').appendChild(
                                    landClone);
                                break;

                            default:
                                // Handle any other or unknown permit type
                                console.log('Unknown Permit Type:', file);
                        }
                    });

                } catch (error) {
                    console.error('Error fetching files:', error);
                } finally {
                    filterForm.classList.remove('opacity-50', 'pointer-events-none');

                }
            });


        });

        function setupLinks(clone, fileId) {
            const viewLink = clone.querySelector('.view-link');
            const downloadLink = clone.querySelector('.download-link');

            if (viewLink) {
                viewLink.setAttribute('onclick', `openFileModal(${fileId})`);
            }
            if (downloadLink) {
                downloadLink.href = `/api/files/download/${fileId}`;
            }
        }

        async function permitType() {
            const select = document.getElementById('select-permit-type');

            try {
                const response = await fetch('/api/permit/type'); // Adjust URL if necessary

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success && Array.isArray(data.permitTypes)) {
                    // Clear existing options
                    select.innerHTML = `
                <option value="" disabled selected hidden>Select Permit Type</option>
            `;

                    // Populate the dropdown
                    data.permitTypes.forEach((type) => {
                        const option = document.createElement('option');
                        option.value = type.type_name;
                        option.textContent = type.type_name.replace(/-/g, ' ');
                        select.appendChild(option);
                    });
                } else {
                    console.error('Invalid response:', data);
                    select.innerHTML = `
                <option value="" disabled>No permit types available</option>
            `;
                }
            } catch (error) {
                console.error('Error fetching permit types:', error.message);

                // Show error in dropdown
                select.innerHTML = `
            <option value="" disabled>Error loading permit types</option>
        `;
            }
        }

        async function municipalities() {
            const select = document.getElementById('municipality');
            try {
                const response = await fetch('/api/municipalities');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                data.locations.forEach((municipality) => {
                    const option = document.createElement('option');
                    option.value = municipality.location;
                    option.textContent = municipality.location;
                    select.appendChild(option);

                });
            } catch {

            }
        }
    </script>
    <script src="{{ asset('js/file-modal.js') }}"></script>

@endsection
