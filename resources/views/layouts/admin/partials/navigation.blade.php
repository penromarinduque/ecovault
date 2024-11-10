<nav class="bg-white border-b border-gray-200 px-4 py-2.5  fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100  focus:ring-2 focus:ring-gray-100">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>
            <section class="flex items-center justify-between mr-4">
                <img src="{{ asset('images/denrlogo.png') }}" class="mr-3 h-8" alt="Penro Logo" />
                <span class="self-center text-gray-600 text-2xl font-semibold whitespace-nowrap">Document Security and
                    Digital
                    Archiving System</span>
            </section>
        </div>
        <div class="flex items-center lg:order-2">
            <!-- toggle side bar-->
            <a href="{{ route('show.qr') }}"> <i
                    class='bx bx-qr-scan bx-sm text-gray-500 p-2 hover:text-gray-900 hover:bg-gray-100 rounded-lg cursor-pointer '></i></a>

            <button type="button" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation"
                class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 ">
                <span class="sr-only">Toggle search</span>
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
                    </path>
                </svg>
            </button>
            <!-- Notifications -->
            <button type="button" data-dropdown-toggle="notification-dropdown"
                class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100   focus:ring-4 focus:ring-gray-300 ">
                <span class="sr-only">View notifications</span>
                <!-- Bell icon -->
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                    </path>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white divide-y divide-gray-100 shadow-lg  rounded-md"
                id="notification-dropdown">
                <div class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 ">
                    Notifications
                </div>
                <div id="notifications-list">

                    <!-- Notifications will be dynamically loaded here -->
                </div>
                <script>
                    async function loadNotifications() {

                        try {
                            // Make a fetch request to your backend API
                            const response = await fetch('/api/notifications');

                            // Check if the response is successful (status 200)
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }

                            // Parse the JSON data
                            const notifications = await response.json();

                            // Get the notifications container
                            const notificationsList = document.getElementById('notifications-list');

                            // Clear any existing notifications before rendering new ones
                            notificationsList.innerHTML = '';

                            // Loop through each notification and create the HTML structure
                            notifications.forEach(notification => {
                                const data = notification.data;

                                // Construct the message content using the notification data
                                const message =
                                    `File ID: ${data.file_id}, Requested By: User ${data.requested_by_user_id}, Permission: ${data.requested_permission}, Status: ${data.status}`;

                                const notificationElement = document.createElement('a');
                                notificationElement.href = "#";
                                notificationElement.classList.add('flex', 'py-3', 'px-4', 'border-b', 'hover:bg-gray-100');

                                // Create the content inside the notification
                                notificationElement.innerHTML = `
                        <div class="flex-shrink-0 relative">
                            <!-- Avatar Image (You can change this to a dynamic avatar later) -->
                            <img class="w-11 h-11 rounded-full" src="https://via.placeholder.com/150" alt="User Avatar" />
                            <div class="flex absolute justify-center items-center ml-6 -mt-5 w-5 h-5 bg-primary-700 rounded-full border border-white">
                                <!-- Notification Icon (adjust as needed) -->
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                                    <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="pl-3 w-full">
                            <div class="text-gray-500 font-normal text-sm mb-1.5">
                                ${message}
                            </div>
                            <div class="text-xs font-medium text-primary-600">
                                ${new Date(notification.created_at).toLocaleString()}
                            </div>
                            <!-- Approve and Reject Buttons -->
                            <div class="mt-2 flex justify-start space-x-2">
                                <button class="bg-green-500 text-white px-2 py-1 rounded" 
                                        onclick="updateRequestStatus(${data.file_id}, 'approved')">Approve</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded" 
                                        onclick="updateRequestStatus(${data.file_id}, 'rejected')">Reject</button>
                            </div>
                        </div>
                        `;

                                // Append the notification to the list
                                notificationsList.appendChild(notificationElement);
                            });
                        } catch (error) {
                            console.error('Error fetching notifications:', error);
                        }
                    }

                    // Function to update the request status (Approve or Reject)
                    async function updateRequestStatus(fileId, status) {
                        const csrfToken = document.querySelector('input[name="_token"]').value;

                        try {
                            const response = await fetch(`/api/files/request-access/${fileId}?status=${status}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                            });

                            const data = await response.json();

                            if (data.success) {
                                alert(data.message); // Display success message
                                loadNotifications(); // Refresh the notifications list
                            } else {
                                console.error(data.message);
                            }
                        } catch (error) {
                            console.error('Error updating request status:', error);
                        }
                    }

                    // Load notifications when the page loads
                    window.onload = loadNotifications;
                </script>
                <a href="#"
                    class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100  ">
                    <div class="inline-flex items-center">
                        <svg aria-hidden="true" class="mr-2 w-4 h-4 text-gray-500 " fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        View all
                    </div>
                </a>
            </div>
            <!--profile-->
            <button type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 "
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full"
                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                    alt="user photo" />
            </button>
            <!-- Dropdown menu -->
            <div class="hidden z-50 my-4 w-56 text-base text-md list-none bg-white divide-y divide-gray-100 shadow rounded-md"
                id="dropdown">
                <div class="py-3 px-4">
                    <span class="block text-md font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="block text-md text-gray-700 truncate">{{ Auth::user()->email }}</span>
                </div>
                <ul class="py-1 text-gray-700 " aria-labelledby="dropdown">

                    <li>
                        <a href="{{ route('show.setting') }}" class="block py-2 px-4  hover:bg-gray-100  ">
                            Settings</a>
                    </li>
                </ul>

                <ul class="py-1 text-gray-700 " aria-labelledby="dropdown">
                    <li>
                        <a href="{{ route('logout.post') }}"
                            class="block py-2 px-4 font-semibold hover:bg-gray-100 ">Log
                            out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


</nav>
