import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Attach Pusher to the window object
window.Pusher = Pusher;

// Initialize Laravel Echo and attach it to the window object
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});
