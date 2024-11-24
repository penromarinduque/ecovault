import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
Pusher.logToConsole = true;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
window.Echo.connector.pusher.bind('pusher:subscription_succeeded', function (members) {
    console.log('Successfully subscribed to the channel', members);
});
console.log(window.Echo);

document.addEventListener('DOMContentLoaded', () => {
    const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

    // Listen to a private channel for the authenticated user
    window.Echo.private(`user.${userId}`)
        .notification((event) => {
            console.log(event);  // Log the event data to console
            const notification = document.createElement('div');
            notification.className = 'fixed z-[100] top-5 right-5 bg-blue-500 text-white p-4 rounded-lg shadow-lg opacity-0 pointer-events-none transform translate-x-full transition-all duration-500 ease-in-out';
            notification.textContent = event.message;

            // Append to the body
            document.body.appendChild(notification);

            // Trigger styles to show the notification
            setTimeout(() => {
                notification.classList.remove('opacity-0', 'pointer-events-none', 'translate-x-full');
                notification.classList.add('opacity-100', 'pointer-events-auto', 'translate-x-0');
            }, 10); // Slight delay to ensure CSS transitions apply

            // Remove the notification after 5 seconds
            setTimeout(() => {
                notification.classList.remove('opacity-100', 'pointer-events-auto', 'translate-x-0');
                notification.classList.add('opacity-0', 'pointer-events-none', 'translate-x-full');

                // Remove the notification from the DOM
                setTimeout(() => {
                    notification.remove();
                }, 500); // Wait for the hide transition to complete before removing
            }, 5000);
        });

});