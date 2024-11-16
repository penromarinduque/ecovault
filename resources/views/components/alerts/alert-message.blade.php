<div id="alert-border-3"
    class="hidden fixed z-50 flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800 transition-all duration-700 ease-in-out opacity-0 transform scale-95"
    role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <div class="ml-3 text-sm font-medium">
        <!-- This message will be dynamically inserted here -->
    </div>
    <button type="button" id="button-alert-dismiss"
        class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
        data-dismiss-target="#alert-border-3" aria-label="Close">
        <span class="sr-only">Dismiss</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>

<script>
    function showToast(message, position = 'top-right', type = 'success', duration = 3000) {
        const alert = document.getElementById('alert-border-3');
        const alertMessage = alert.querySelector('.ml-3'); // Select the message container
        const button = document.getElementById('button-alert-dismiss');

        // Set the dynamic message
        alertMessage.textContent = message;

        // Reset button and alert styles to remove previous color classes
        button.classList.remove('bg-red-50', 'text-red-500', 'focus:ring-red-400', 'hover:bg-red-200');
        button.classList.remove('bg-green-50', 'text-green-500', 'focus:ring-green-400', 'hover:bg-green-200');

        // Set color based on type
        if (type === 'success') {
            alert.classList.remove('bg-red-50', 'text-red-800', 'border-red-300');
            alert.classList.add('bg-green-50', 'text-green-800', 'border-green-300');
            button.classList.add('bg-green-50', 'text-green-500', 'focus:ring-green-400', 'hover:bg-green-200');
        } else if (type === 'danger') {
            alert.classList.remove('bg-green-50', 'text-green-800', 'border-green-300');
            alert.classList.add('bg-red-50', 'text-red-800', 'border-red-300');
            button.classList.add('bg-red-50', 'text-red-500', 'focus:ring-red-400', 'hover:bg-red-200');
        }

        // Set position based on the passed argument (top-left, top-right, bottom-left, bottom-right)
        alert.classList.remove('top-20', 'bottom-5', 'right-5', 'left-5'); // Remove all position classes
        if (position === 'top-right') {
            alert.classList.add('top-20', 'right-5');
        } else if (position === 'top-left') {
            alert.classList.add('top-20', 'left-5');
        } else if (position === 'bottom-right') {
            alert.classList.add('bottom-5', 'right-5');
        } else if (position === 'bottom-left') {
            alert.classList.add('bottom-5', 'left-5');
        }

        // Remove hidden class and fade/scale it into view
        alert.classList.remove('hidden', 'opacity-0', 'scale-95');
        alert.classList.add('opacity-100', 'scale-100');

        // Delay opacity and scale transitions before fade-out
        setTimeout(() => {
            alert.classList.remove('opacity-100', 'scale-100');
            alert.classList.add('opacity-0', 'scale-95');

            // Delay the complete hide after animation
            setTimeout(() => {
                alert.classList.add('hidden');
            }, 500); // Match the transition duration for opacity
        }, duration); // Duration before auto-hide (defaults to 3000ms)
    }
</script>
