<div id="card-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Cards will be dynamically added here -->

</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchDataCard();
    });

    let report1 = {!! json_encode($record ?? '') !!};
    let isAdmin1 = {!! json_encode($isAdmin) !!};
    let type1 = {!! json_encode($type ?? '') !!};
    let municipality1 = {!! json_encode($municipality ?? '') !!};
    let category1 = {!! json_encode($category ?? '') !!};
    let isArchived1 = {!! json_encode($isArchived ?? false) !!};

    async function fetchDataCard() {
        const params = {
            type: type1,
            municipality: municipality1,
            report: report1,
            category: category1,
            isArchived: isArchived1
        };

        // Remove parameters that are undefined or null
        const filteredParams = Object.fromEntries(
            Object.entries(params).filter(([_, value]) => value !== null && value !== undefined)
        );

        // Build the query string
        const queryParams = new URLSearchParams(filteredParams).toString();

        try {
            const response = await fetch(`/api/files?${queryParams}`);
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Fetch failed with status: ${response.status} - ${errorText}`);
            }

            const data = await response.json();

            if (data.success) {
                console.log(data)
                // renderCards(data.data); // Assuming `data.data` contains the file records
            } else {
                console.error('Failed to retrieve files:', data.message);

            }
        } catch (error) {
            console.error('Fetch operation error:', error.message || error);

        }
    }

    // Function to create a card dynamically




    // Function to render cards dynamically
</script>
