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
console.log(window.Echo);

//for listening for events
//const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');


console.log('Echo initialized:', window.Echo);
document.addEventListener('DOMContentLoaded', () => {
    const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

   window.Echo.private(`user.${userId}`)
    .listen('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (event) => {
        console.log('Notification received:', event);
        alert(`New Notification: ${event.message}`);
    });
});

