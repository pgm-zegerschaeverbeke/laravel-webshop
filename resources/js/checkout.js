// voorkomt spam op submit button van checkout form door de disable en te tonen dat er een request wordt verzonden
document.addEventListener('DOMContentLoaded', function() {
    const $checkoutForm = document.getElementById('checkout-form');
    if (!$checkoutForm) return;
    
    $checkoutForm.addEventListener('submit', function(e) {
        const $submitButton = this.querySelector('button[type="submit"]');
        if ($submitButton && !$submitButton.disabled) {
            $submitButton.disabled = true;
            $submitButton.textContent = 'Processing...';
            $submitButton.style.cursor = 'default';
            $submitButton.classList.add('opacity-50');
        } else {
            e.preventDefault();
        }
    });
});

