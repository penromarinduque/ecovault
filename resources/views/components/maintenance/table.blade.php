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

  </div>

  <button data-modal-target="delete-modal" data-modal-toggle="delete-modal"
      class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      type="button">
      Toggle modal
  </button>

  @foreach ($speciesList as $species)
      <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4">{{ $loop->iteration }}</td>
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $species->common_name ?? 'N/A' }} <span class="text-blue-700">/</span> {{ $species->scientific_name }}
          </th>
          <td class="px-6 py-4">{{ $species->family ?? 'N/A' }}</td>
          <td class="px-6 py-4">{{ $species->genus ?? 'N/A' }}</td>
          <td class="px-6 py-4">{{ $species->description ?? 'N/A' }}</td>
          <td class="px-6 py-4 text-right">
              <button data-modal-target="delete-modal-{{ $species->id }}"
                  data-modal-toggle="delete-modal-{{ $species->id }}"
                  class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
          </td>
      </tr>

      <div id="delete-modal-{{ $species->id }}" tabindex="-1"
          class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <button type="button"
                      class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-hide="delete-modal-{{ $species->id }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
                  <div class="p-4 md:p-5 text-center">
                      <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                      <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                          delete
                          this species?</h3>
                      <form action="{{ route('species.destroy', $species->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                              class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                              Yes, I'm sure
                          </button>
                      </form>
                      <button data-modal-hide="delete-modal-{{ $species->id }}" type="button"
                          class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                          cancel</button>
                  </div>
              </div>
          </div>
      </div>
  @endforeach



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

                      row.innerHTML = `
                    <td class="px-6 py-4">${index + 1}</td> <!-- Row number -->
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        ${species.common_name || 'N/A'} <span class="text-blue-700">/</span> ${species.scientific_name}
                    </th>
                    <td class="px-6 py-4">${species.family || 'N/A'}</td>
                    <td class="px-6 py-4">${species.genus || 'N/A'}</td>
                    <td class="px-6 py-4">${species.description || 'N/A'}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit delete</a>
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

                      row.innerHTML = `
                  <td class="px-6 py-4">${index + 1}</td> <!-- Row number -->
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                      ${species.name}
                  </th>
                  <td class="px-6 py-4 text-right">
                      <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                  </td>
              `;
                      tableBody.appendChild(row);
                  });
              })


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
  </script>
