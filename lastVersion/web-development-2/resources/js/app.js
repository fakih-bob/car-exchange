import './bootstrap';

console.log("🔥 Echo loaded:", window.Echo);
// Replace this with the actual driver ID from your backend (e.g. using meta tag or blade)
const driverId = document.head.querySelector('meta[name="driver-id"]')?.content;

if (driverId) {
    window.Echo.channel(`driver-channel-${driverId}`)
        .listen('.new-delivery', (e) => {
            console.log('📦 New delivery request:', e);
            alert(`📦 New delivery request: ${e.message}`);
        });
}

    window.Echo.channel('test-channel')
    .listen('.test-event', (e) => {
        console.log('🧪 Test Broadcast:', e.message);
        alert(`📢 Test: ${e.message}`);
    });