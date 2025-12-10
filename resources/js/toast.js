export function showToast(type, message) {
    const toastElement = document.getElementById('toast-container');
    if (!toastElement) return;
    
    try {
        const data = Alpine.$data(toastElement);
        if (data) {
            data.show = true;
            data.message = message;
            data.type = type;
            setTimeout(() => {
                data.show = false;
            }, 1500);
        }
    } catch (e) {
        console.error('Error showing toast:', e);
    }
}

