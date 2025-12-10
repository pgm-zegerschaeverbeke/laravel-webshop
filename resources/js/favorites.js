// Favorites functionality
import { getCsrfToken } from './cart';
import { showToast } from './toast';


// functie om favorites count in desktop header en mobile menu te updaten
function updateFavoritesCount(count) {
    document.querySelectorAll('[data-favorites-count]').forEach($counter => {
        $counter.textContent = count;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button clicks
    document.addEventListener('click', async function(e) {
        // zoekt dichtste parent met data-toggle-favorite attribute
        const $button = e.target.closest('[data-toggle-favorite]');
        if (!$button) return;

        e.preventDefault();
        // disable button om spam te voorkomen
        $button.disabled = true;
        
        try {
            const response = await fetch(`/favorites/toggle/${$button.dataset.productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
            });

            if (!response.ok) throw new Error('Failed to toggle favorite');

            const data = await response.json();
            // favorites count in header updaten
            updateFavoritesCount(data.count);
            // set isFavorited attribute op button
            $button.dataset.isFavorited = data.isFavorited ? 'true' : 'false';
            
            // toon toast notification (tenzij button heeft data-no-toast) dus in de favorite page geen toast omdat er als visuele update is
            if (!$button.dataset.noToast) {
                if (data.isFavorited) {
                    showToast('favorite', 'Item added to favorites');
                } else {
                    showToast('removed', 'Removed from favorites');
                }
            }
            
            // Update button styling
            $button.classList.toggle('bg-accent', data.isFavorited);
            $button.classList.toggle('hover:bg-accent-dark', data.isFavorited);
            $button.classList.toggle('bg-primary', !data.isFavorited);
            $button.classList.toggle('hover:bg-text-secondary', !data.isFavorited);
            $button.classList.toggle('hover:text-primary', !data.isFavorited);
            
            // als verwijdert van favorites op favorites page, fade out en item verwijderen na 300ms en als lijst leeg is, pagina herladen
            if (!data.isFavorited && window.location.pathname === '/favorites') {
                const $item = $button.closest('[data-favorite-item]');
                if ($item) {
                    $item.style.opacity = '0';
                    setTimeout(() => {
                        $item.remove();
                        const $favoritesList = document.querySelector('[data-favorites-list]');
                        if (!$favoritesList?.children.length) {
                            window.location.reload();
                        }
                    }, 300);
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to update favorite. Please try again.');
        } 
        // enable button wanneer request klaar is
        finally {
            $button.disabled = false;
        }
    });
    
    // haalt initiele count op van favorites via API en updatet de favorite counts in header en mobile menu via updateFavoritesCount functie
    async function loadFavoritesCount() {
        try {
            const response = await fetch('/favorites/count', {
                headers: { 'Accept': 'application/json' }
            });
            
            if (response.ok) {
                const data = await response.json();
                updateFavoritesCount(data.count);
            }
        } catch (error) {
            console.warn('Could not fetch favorites count from server:', error);
        }
    }
    
    loadFavoritesCount();
});

