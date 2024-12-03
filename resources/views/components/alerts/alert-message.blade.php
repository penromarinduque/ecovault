<div id="toast-container" class="fixed top-20 right-10 z-[80] space-y-2">
    <!--display the toast here-->
</div>

<template id="toast-template">
    <div id="toast" class="flex items-center w-full max-w-xs p-4 mb-4 rounded-lg shadow text-slate-200 bg-gray-700"
        role="alert">
        <div id="toast-icon" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full">
            <!-- Dynamic icon will be inserted here -->
        </div>
        <div id="toast-message" class="ms-3 text-sm font-normal">
            <!-- Dynamic message will be inserted here -->
        </div>
        <button
            class="close-toast ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 text-gray-100 hover:text-white bg-gray-700 hover:bg-gray-700"
            aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</template>

<script>
    function showToast({
        type = 'success',
        message = '',
        timeout = 10000
    } = {}) {
        const container = document.querySelector('#toast-container'); // Ensure this container exists in your HTML
        const template = document.querySelector('#toast-template');
        const toastFragment = template.content.cloneNode(true);
        const toast = toastFragment.querySelector('#toast'); // Grab the toast element

        const toastIcon = toast.querySelector('#toast-icon');
        const toastMessage = toast.querySelector('#toast-message');

        toastMessage.textContent = message;

        // Set the dynamic message and icon based on type
        switch (type) {
            case 'success':
                toastIcon.classList.add('text-green-500', 'bg-green-100');
                toastIcon.innerHTML = `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>`;
                break;
            case 'danger':
                toastIcon.classList.add('text-red-500', 'bg-red-100');
                toastIcon.innerHTML = `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                    </svg>`;
                break;
            default:
                toastIcon.classList.add('text-blue-500', 'bg-blue-100');
                toastIcon.innerHTML = `<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                    </svg>`;
                break;
        }

        container.appendChild(toast);

        // Animation for slide-in
        toast.classList.add('animate-slideIn');

        // Close button functionality
        const closeToast = toast.querySelector('.close-toast');
        if (closeToast) {
            closeToast.addEventListener('click', () => removeToast(toast));
        }

        // Auto-remove toast after timeout
        setTimeout(() => removeToast(toast), timeout);
    }

    function removeToast(toast) {
        toast.classList.remove('animate-slideIn');
        toast.classList.add('animate-fadeOut');

        toast.addEventListener('animationend', () => {
            toast.remove();
        }, {
            once: true
        });
    }
</script>
@if (session('success'))
    <script>
        showToast({
            type: 'success',
            message: "{{ session('success') }}",
        });
    </script>
@endif
@if (session('error'))
    <script>
        showToast({
            type: 'danger',
            message: "{{ session('error') }}",
        });
    </script>
@endif
