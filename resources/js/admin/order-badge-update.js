import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "41b38481e9ba43e1ba39",
    cluster: 'eu',
    forceTLS: true
});

window.Echo.channel("orders")
    .listen("OrderUpdated", (data) => {

        // Update badge instantly
        let badgeEl = document.getElementById("orders-badge");

        if (badgeEl) {
            badgeEl.innerText = data.pendingCount;
        }

        console.log("Realtime updated:", data.pendingCount);
    });
