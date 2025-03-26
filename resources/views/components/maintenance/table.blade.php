  <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
  <div>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

          </table>
          <table id="speciesTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">Common Name / Scientific Name</th>
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
      </div>

  </div>
  <script>
      // Fetch data from the server and update the table dynamically
      function loadSpecies() {
          fetch('/show/species/ltp')
              .then(response => response.json())
              .then(speciesList => {
                  const tableBody = document.getElementById("speciesTableBody");
                  tableBody.innerHTML = ""; // Clear previous rows

                  speciesList.forEach(species => {
                      // Create a new row for each butterfly species
                      const row = document.createElement("tr");
                      row.classList.add("bg-white", "dark:bg-gray-800", "hover:bg-gray-50",
                          "dark:hover:bg-gray-600");

                      row.innerHTML = `
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${species.common_name || 'N/A'} / ${species.scientific_name}
                        </th>
                        <td class="px-6 py-4">${species.family || 'N/A'}</td>
                        <td class="px-6 py-4">${species.genus || 'N/A'}</td>
                        <td class="px-6 py-4">${species.description || 'N/A'}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    `;
                      tableBody.appendChild(row);
                  });
              })
              .catch(error => {
                  console.error("Error fetching species:", error);
              });
      }

      // Call the function to load species data when the page is loaded
      document.addEventListener("DOMContentLoaded", loadSpecies);
  </script>
