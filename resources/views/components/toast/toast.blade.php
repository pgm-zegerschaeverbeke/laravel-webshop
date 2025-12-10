<div 
    id="toast-container"
    x-data="{ 
        show: false, 
        message: '', 
        type: 'cart'
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    class="fixed top-20 right-4 z-50"
>
    <div class="bg-background border border-subtle rounded-lg shadow-lg px-4 py-3 flex items-center gap-3 min-w-[280px]">
        <div class="text-accent flex-shrink-0">
            <template x-if="type === 'cart'">
                <x-css-shopping-bag class="w-6 h-6" />
            </template>
            <template x-if="type === 'favorite'">
                <x-far-heart class="w-6 h-6" />
            </template>
            <template x-if="type === 'removed'">
                <x-heroicon-c-x-mark class="w-6 h-6" />
            </template>
        </div>
        <p class="text-primary flex-1" x-text="message"></p>
    </div>
</div>

