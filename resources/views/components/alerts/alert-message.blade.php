<!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
<div id="alert-error"
    class="fixed hidden left-0 right-0 mx-auto top-5 p-4 z-[60] mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 max-w-md"
    role="alert">
    <div class="flex items-center">
        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Error</span>
        <h3 id="error-alert-title" class="text-lg font-medium">Error occured!</h3>
    </div>
    <div id="error-alert-message" class="mt-2 mb-4 text-sm">
        <!-- Error message will go here -->
    </div>
    <div class="flex">
        <button type="button"
            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
            View more
        </button>
        <button type="button"
            class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center"
            onclick="dismissAlert()">
            Dismiss
        </button>
    </div>
</div>


<div id="alert-success"
    class="fixed left-0 hidden right-0 mx-auto top-5 p-4 mb-4 z-[60] text-green-800 border border-green-300 rounded-lg bg-green-50 max-w-md"
    role="alert">
    <div class="flex items-center">
        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <h3 class="text-lg font-medium">Success!</h3>
    </div>
    <div id="success-alert-message" class="mt-2 mb-4 text-sm">
        <!-- display message here-->
    </div>
    <div class="flex">
        <button type="button"
            class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center">
            <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 14">
                <path
                    d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
            </svg>
            View more
        </button>
        <button type="button"
            class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
            Dismiss
        </button>
    </div>
</div>

<script>
    function showErrorAlert(message) {
        const alert = document.getElementById('alert-error');
        const alertMessage = document.getElementById('error-alert-message');

        alertMessage.innerText = message; // Set the error message

        alert.classList.remove('hidden'); // Show the alert

        // Hide the alert after 5 seconds
        setTimeout(() => {
            alert.classList.add('hidden');
        }, 5000);
    }

    // Function to dismiss the alert manually
    function dismissAlert() {
        const alert = document.getElementById('alert-error');
        alert.classList.add('hidden'); // Hide the alert when the dismiss button is clicked
    }

    function showSuccessAlert(message, title = "Success") {
        // Get the alert elements
        const alert = document.getElementById('alert-success');
        const alertMessage = document.getElementById('success-alert-message');

        alertMessage.innerText = message;

        // Remove the 'hidden' class to display the alert
        alert.classList.remove('hidden');

        // Optionally, hide the alert after 5 seconds
        setTimeout(() => {
            alert.classList.add('hidden');
        }, 5000);
    }

    function dismissAlert() {
        const alert = document.getElementById('alert-success');
        alert.classList.add('hidden');
    }
</script>
