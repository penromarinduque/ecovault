const notificationsList = document.getElementById('notifications-list');
const noNotificationsMessage = document.getElementById('no-notifcations-message');
const notificationIndicator= document.getElementById('notification-indicator');

export function updateFetchNotification() {
    axios.get('/api/notifications') // Replace with your correct route
        .then(response => {
            const notifications = response.data; // Access the data from the response

            //notificationsList.innerHTML = ''; // Clear the list before appending new notifications

            if (notifications.length === 0) { // Check if notifications array is empty
                noNotificationsMessage.classList.remove('hidden'); // Show the "No notifications" message
                
            } else {
                notificationIndicator.classList.remove('hidden');
                noNotificationsMessage.classList.add('hidden'); // Hide the "No notifications" message
                notifications.forEach(notification => {
                    // Access the template and clone its content
                    const template = document.getElementById('notification-list-template');
                    const templateContent = template.content.cloneNode(true); // Clone the template content

                    templateContent.querySelector('.fileShare-sender-name').textContent = notification.data.senderName;
                    templateContent.querySelector('.fileShare-file-name').textContent = notification.data.fileName;

                    notificationsList.appendChild(templateContent); // Append each notification
                });
            }
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });
}