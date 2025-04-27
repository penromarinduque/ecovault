@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 overflow-y-auto overflow-x-hidden  top-0 right-0 left-0">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Species
                    </h3>

                </div>

                <!-- Modal body -->
                <form id="edit-form">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        @if ($speciesType == 'butterfly')
                            <input type="hidden" name="species_type" value="butterfly">
                            <div>
                                <label for="Scientific-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Scientific
                                    Name</label>
                                <input type="text" name="scientific_name" id="scientific-name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Scientific name" required="">
                            </div>
                            <div>
                                <label for="commom-name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Common Name</label>
                                <input type="text" name="common_name" id="common-name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Common name">
                            </div>
                            <div>
                                <label for="family"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Family</label>
                                <input type="text" name="family" id="family"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="family">
                            </div>
                            <div>
                                <label for="genus"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Genus</label>
                                <input type="text" name="genus" id="genus"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="genus">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="description" rows="4" name="description"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Write species description here" required></textarea>
                            </div>
                        @elseif($speciesType == 'tree')
                            <div>
                                <label for="common_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Genus</label>
                                <input type="text" name="common_name" id="common_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="genus">
                            </div>
                        @endif
                    </div>
                    <button type="submit"
                        class="bg-green-500 text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Submit
                    </button>

                    <a href="{{ route('show.maintenance.table', ['speciesType' => $speciesType]) }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
    <!-- Inside edit-maintenance.blade.php -->
    <script>
        // Get the speciesType and id values from Blade
        const speciesType = @json($speciesType);
        const id = @json($id);

        // Fetch CSRF token from meta tag


        async function fetchSpeciesData() {
            try {
                let url = '';

                if (speciesType === 'butterfly') {
                    url = `/species/edit/${id}`;
                } else if (speciesType === 'tree') {
                    url = `/api/tree-species/${id}`;
                } else {
                    console.error('Unknown species type:', speciesType);
                    return;
                }

                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                // Populate the form fields with the fetched data
                if (speciesType === 'butterfly') {
                    document.getElementById('scientific-name').value = data.scientific_name;
                    document.getElementById('common-name').value = data.common_name;
                    document.getElementById('family').value = data.family;
                    document.getElementById('genus').value = data.genus;
                    document.getElementById('description').value = data.description;
                } else if (speciesType === 'tree') {
                    document.getElementById('common_name').value = data.common_name;
                }
            } catch (error) {
                console.error('Error fetching species data:', error);
            }
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('edit-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData(event.target);
            const formDataJson = Object.fromEntries(formData);

            let url = '';

            if (speciesType === 'butterfly') {
                url = `/update/species/${id}`;
            } else if (speciesType === 'tree') {
                url = `/api/tree-species/update/${id}`;
            } else {
                console.error('Unknown species type:', speciesType);
                return;
            }

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify(formDataJson),
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                console.log('Updated Species:', data);
                showToast({
                    type: 'success',
                    message: 'Species updated successfully!',
                });
            } catch (error) {
                console.error('Error updating species:', error);
                showToast({
                    type: 'danger',
                    message: 'Error updating the species!',
                });
            }
        });

        // Call the function to fetch species data when the page loads
        window.onload = fetchSpeciesData;
    </script>


@endsection
