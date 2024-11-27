<!-- Simplicity is an acquired taste. - Katharine Gerould -->
<!-- made by  harvey orencio-->
<!--everyhting here is use for notification templating-->
<div id="notification-container" class="fixed top-20 right-10 z-[80] space-y-2"><!--populate all the notification here -->
</div>

<template id="notification-list-template">
    <li class="border border-gray-200 rounded-lg shadow hover:shadow-md transition-shadow mb-3">
        <a href="#" class="capitalize flex items-center px-4 py-3 mt-0 bg-white hover:bg-gray-50 rounded-lg">
            <div class="flex-shrink-0">
            </div>
            <div class="flex-grow">
                <div class="text-gray-700 text-sm font-medium whitespace-normal break-all">
                    <span class="notice-sender-name text-blue-600 font-semibold">Admin</span>
                    <span class="notice-type">shared file</span>
                    <span class="notice-file-name text-pretty font-medium text-gray-900"></span>
                    {{-- <span class="notice-receiver-name text-blue-600 font-semibold">you.</span> --}}
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    <span class="notice-time">Just now</span>
                </div>
            </div>
        </a>
    </li>
</template>

<template id="notification-template">
    <div class="capitalize notification-item w-full min-w-72 p-4 rounded-lg shadow bg-gray-800 text-gray-400"
        role="alert">
        <div class="flex">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg text-blue-300 bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                </svg>

                <span class="sr-only">Refresh icon</span>
            </div>
            <div class="ms-3 font-normal">
                <span class="notification-sender-name mb-1 font-bold text-lg text-white">Harvey Orencio</span>
                <div class="mb-2 w-72 text-base font-normal mt-2">
                    <span class="notification-type text-white">File Share:</span>
                    <span
                        class="notification-file-name text-pretty text-gray-200 max-h-60">1732078457_1731180190_1730033323_lrme-export__4___1_.pdf</span>
                </div>
                <h6 class="notification-message text-gray-100 mb-2 font-normal">"sample message"
                </h6>
                <div class="notification-action-btn grid grid-cols-2 gap-2">
                    <div>
                        <a href="#"
                            class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white  rounded-lg  focus:ring-4 focus:outline-none  bg-blue-500 hover:bg-blue-600 focus:ring-blue-800">Approve</a>
                    </div>
                    <div>
                        <a href="#"
                            class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white border rounded-lg focus:ring-4 focus:outline-none bg-red-600 border-red-600 hover:bg-red-700 hover:border-red-700 focus:ring-red-700">Reject</a>
                    </div>
                </div>
            </div>
            <button
                class="close-notification ms-auto -mx-1.5 -my-1.5 items-center justify-center flex-shrink-0 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex h-8 w-8 text-white hover:text-white bg-gray-800 hover:bg-gray-700"
                data-dismiss-target="#toast-interactive" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>
</template>


<script>
    function showNotification(senderName, message, notifyType, title, fileName) {
        // Select the container and template
        const container = document.getElementById('notification-container');
        const template = document.getElementById('notification-template');

        // Clone the template content
        const notificationFragment = template.content.cloneNode(true);

        // Update notification content
        notificationFragment.querySelector('.notification-sender-name').textContent = senderName;
        notificationFragment.querySelector('.notification-type').textContent = `${notifyType}:`;
        notificationFragment.querySelector('.notification-file-name').textContent = fileName;
        notificationFragment.querySelector('.notification-message').textContent = message ? `"${message}"` : '';

        const actionsDiv = notificationFragment.querySelector('.notification-action-btn');
        if (notifyType === 'file request') {
            actionsDiv.classList.remove('hidden');
        }


        // Create a wrapper for the notification to append properly
        const wrapper = document.createElement('div');
        wrapper.appendChild(notificationFragment);

        // Append the wrapper's first child (the notification item) to the container
        const appendedNotification = container.appendChild(wrapper.firstElementChild);

        // Add slideIn animation
        appendedNotification.classList.add('animate-slideIn');

        // Close button logic
        const closeButton = appendedNotification.querySelector('.close-notification');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                fadeOutAndRemove(appendedNotification);
            });
        }

        // Auto-remove the notification after 5 seconds
        setTimeout(() => {
            fadeOutAndRemove(appendedNotification);
        }, 700000);
    }

    function fadeOutAndRemove(notification) {
        // Add fadeOut animation
        notification.classList.remove('animate-slideIn');
        notification.classList.add('animate-fadeOut');

        // Remove the element after the animation ends
        notification.addEventListener('animationend', () => {
            notification.remove();
        }, {
            once: true
        });
    }
</script>
