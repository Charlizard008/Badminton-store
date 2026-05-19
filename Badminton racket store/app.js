// Ask confirmation before wiping data from DB
function confirmDelete(event, modelName) {
    const userConfirmed = confirm(`Are you sure you want to permanently delete the ${modelName} from inventory?`);
    
    if (!userConfirmed) {
        event.preventDefault();
        return false;
    }
    return true;
}

// Watch URL state for status feedback alerts
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'deleted') {
        alert('Racket successfully removed from stock.');
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (status === 'added') {
        alert('New racket successfully registered to inventory!');
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});