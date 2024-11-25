const notificationsList = document.getElementById('notification-list');
const noNotificationsMessage = document.getElementById('no-notifications-message');


export function updateFetchNotification() {
    axios.get('/api/notifications') // Replace with your correct route
        .then(response => {
            const notifications = response.data; // Access the data from the response

            notificationsList.innerHTML = ''

            if (notificationsList.length === 0) {
                noNotificationsMessage.classList.remove('hidden');
            } else {
                noNotificationsMessage.classList.add('hidden');
            }

            notifications.forEach(notification => {
                // Access the template and clone its content
                const template = document.getElementById('notification-list-template');
                const templateContent = template.content.cloneNode(true); // Clone the template content


                templateContent.querySelector('.fileShare-sender-name').textContent = notification.data.senderName;
                templateContent.querySelector('.fileShare-file-name').textContent = notification.data.fileName;

                notificationsList.appendChild(templateContent);
            });
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });
}