<!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
<div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        </table>
        @if ($speciesType == 'butterfly')
            <table id="speciesTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Common Name <span class="text-blue-700">/</span>
                            Scientific
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">Family</th>
                        <th scope="col" class="px-6 py-3">Genus</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody id="speciesTableBody">
                    <!-- Rows will be dynamically injected here -->
                </tbody>
            </table>
        @elseif($speciesType == 'tree')
            <table id="treeSpeciesTable"
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Species Name
                        </th>

                        <th scope="col" class="px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody id="treeSpeciesTableBody">
                    <!-- Rows will be dynamically injected here -->
                </tbody>
            </table>
        @endif
    </div>

    <div id="delete-modal" tabindex="-1"
        class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                        delete
                        this species?</h3>
                    <button type="button"
                        class="confirm-delete-btn text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button type="button"
                        class="cancel-btn py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fetch data from the server and update the table dynamically
    function loadButterflySpecies() {
        fetch('/show/species/ltp')
            .then(response => response.json())
            .then(speciesList => {
                const tableBody = document.getElementById("speciesTableBody");
                tableBody.innerHTML = ""; // Clear previous rows
                console.log("Species List: ", speciesList);
                speciesList.forEach((species, index) => {
                    // Create a new row for each butterfly species
                    const row = document.createElement("tr");
                    row.classList.add("bg-white", "dark:bg-gray-800", "hover:bg-gray-50",
                        "dark:hover:bg-gray-600");

                    // Dynamically create the edit URL with speciesType and species.id
                    const editUrl =
                        `/show/edit/maintenance/{{ $speciesType }}/${species.id}`;

                    row.innerHTML = `
                    <td class="px-6 py-4">${index + 1}</td> <!-- Row number -->
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        ${species.common_name || 'N/A'} <span class="text-blue-700">/</span> ${species.scientific_name}
                    </th>
                    <td class="px-6 py-4">${species.family || 'N/A'}</td>
                    <td class="px-6 py-4">${species.genus || 'N/A'}</td>
                    <td class="px-6 py-4">${species.description || 'N/A'}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="${editUrl}"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                            Edit
                        </a>
                        <button data-id="${species.id}" class="delete-btn hover:bg-red-900 inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                            Delete
                        </button>
                    </td>
                `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error fetching species:", error);
            });
    }


    function showTreeSpecies() {
        fetch('/api/tree-species')
            .then(response => response.json())
            .then(speciesList => {
                const tableBody = document.getElementById("treeSpeciesTableBody");
                tableBody.innerHTML = "";

                speciesList.forEach((species, index) => {
                    // Create a new row for each butterfly species
                    const row = document.createElement("tr");
                    row.classList.add("bg-white", "dark:bg-gray-800", "hover:bg-gray-50",
                        "dark:hover:bg-gray-600");

                    const editUrl =
                        `/show/edit/maintenance/{{ $speciesType }}/${species.id}`;
                    // Dynamically create the edit URL with speciesType and species.id

                    row.innerHTML = `
                  <td class="px-6 py-4">${index + 1}</td> <!-- Row number -->
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                      ${species.common_name}
                  </th>
                 <td class="px-6 py-4 text-right space-x-2">
          <a href="${editUrl}"
                            class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                            Edit
                        </a>
        <button data-id="${species.id}" class="delete-btn hover:bg-red-900  inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
            Delete
        </button>
    </td>
              `;
                    tableBody.appendChild(row);
                });
            })


    }

    function deleteSpecies(speciesId) {
        // Make a DELETE request to the server to delete the species
        let url = '';
        if ("{{ $speciesType }}" == 'butterfly') {
            url = `/delete/butterfly/species/${speciesId}`;
        } else if ("{{ $speciesType }}" == 'tree') {
            url = `/api/tree-species/${speciesId}`;
        }

        fetch(url, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => {
                if (response.ok) {
                    // Species deleted successfully, reload the table
                    if ("{{ $speciesType }}" == 'butterfly') {
                        loadButterflySpecies();
                    } else if ("{{ $speciesType }}" == 'tree') {
                        showTreeSpecies();
                    }
                    showToast({
                        type: 'success',
                        message: 'Species successfully deleted.',

                    });
                } else {
                    showToast({
                        type: 'danger',
                        message: 'Failed to delete the species.',

                    });
                }
            })
            .catch(error => {
                console.error("Error deleting species:", error);
            });

    }

    function deleteModal(speciesId) {
        const modal = document.getElementById("delete-modal");

        // Update the modal content with the species ID
        const modalTitle = modal.querySelector("h3");
        modalTitle.textContent = `Are you sure you want to delete species?`;

        // Add a click event listener to the confirm button
        const confirmButton = modal.querySelector(".confirm-delete-btn");
        confirmButton.onclick = function() {
            console.log("Deleting species with ID:", speciesId);
            deleteSpecies(speciesId);
            // Hide the modal after deletion
            modal.classList.add("hidden");
        };
        // Show the modal
        modal.classList.remove("hidden");
        const cancelButton = modal.querySelector(".cancel-btn");
        cancelButton.onclick = function() {
            modal.classList.add("hidden");
        };
    }
    // Call the function to load species data when the page is loaded
    document.addEventListener("DOMContentLoaded", () => {

        console.log("Species Type: ", "{{ $speciesType }}");
        if ("{{ $speciesType }}" == 'butterfly') {
            loadButterflySpecies();
        } else if ("{{ $speciesType }}" == 'tree') {
            showTreeSpecies();
        }
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-btn")) {
            const speciesId = event.target.getAttribute("data-id");
            deleteModal(speciesId);
        }
    });
</script>
