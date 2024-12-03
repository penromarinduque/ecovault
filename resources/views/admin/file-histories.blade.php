@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <div class="overflow-auto rounded-md text-black p-4">
        <div id="history-container" class="bg-gray-100 p-4 rounded-lg shadow">
            <p class="text-center text-gray-600">Loading file histories...</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const container = document.getElementById('history-container');
            const fileId = {!! json_encode($fileId) !!};
            try {
                const response = await fetch(`/api/history?file_id=${fileId}'`);
                const result = await response.json();

                // Check if request was successful
                if (!result.success) {
                    container.innerHTML =
                        `<p class="text-center text-red-500">${result.message || 'Failed to load histories.'}</p>`;
                    return;
                }

                const histories = result.history;

                // Handle empty history
                if (histories.length === 0) {
                    container.innerHTML =
                        '<p class="text-center text-gray-600">No history found for this file.</p>';
                    return;
                }

                // Populate table with history data
                container.innerHTML = `
                 <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <tr class="bg-gray-200 text-left">
                         
                           
                            <th class="p-3 border">User ID</th>
                               <th class="p-3 border">Action</th>
                            <th class="p-3 border">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${histories.map(history => `
                                                                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                                              <td class="p-3 border">${history.user_id || 'N/A'}</td>
                                                                            <td class="p-3 border">${history.action}</td>                                            
                                                                          
                                                                            <td class="p-3 border">${new Date(history.created_at).toLocaleString()}</td>
                                                                        </tr>
                                                                    `).join('')}
                    </tbody>
                </table>
            `;
            } catch (error) {
                // Handle fetch or parsing errors
                container.innerHTML = `<p class="text-red-500">Error loading histories: ${error.message}</p>`;
            }
        });

        /**
         * Format the 'changes' field for better readability.
         */
        function formatChanges(changes) {
            try {
                const parsed = JSON.parse(changes);
                return `<pre class="bg-gray-50 p-2 rounded">${JSON.stringify(parsed, null, 2)}</pre>`;
            } catch {
                return changes || '<i>No changes recorded</i>';
            }
        }
    </script>

@endsection
