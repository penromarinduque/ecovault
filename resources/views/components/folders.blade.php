{{-- <div>
    <!-- Folder cards will be dynamically appended here -->
</div>

<script>
    function fetchFolders(folderType) {
        fetch(`/api/folders?folderType=${folderType}&municipality=${municipality}`)
            .then(response => response.json())
            .then(data => {

            })
            .catch(error => console.error('Error fetching folders:', error));
    }

    document.addEventListener("DOMContentLoaded", function() {
        const folderType = type || record; // Replace with dynamic value if needed
        fetchFolders(folderType);
    });
</script> --}}
