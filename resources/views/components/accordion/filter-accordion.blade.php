@props([
    'title' => 'Filter',
    'items' => [],
    'selectedItemsExpression' => 'selectedItems', // Alpine expression for selected items array
    'toggleFunction' => 'toggleFilter', // Function name to call on item click
    'storageKey' => 'filterAccordion', // localStorage key for accordion state
])

<div x-data="{
    isOpen: localStorage.getItem('{{ $storageKey }}') === 'true',
    toggle() {
        this.isOpen = !this.isOpen;
        localStorage.setItem('{{ $storageKey }}', this.isOpen);
    }
}" class="w-full">
    <div class="border-t border-subtle">
        <button @click="toggle()" class="w-full flex items-center justify-between py-3 px-0 text-left uppercase text-primary hover:text-accent transition-colors cursor-pointer relative">
            <span class="font-medium">{{ $title }}</span>
            <div class="relative w-5 h-5">
                <svg 
                    x-show="!isOpen" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 rotate-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0 rotate-0"
                    class="w-5 h-5 absolute inset-0" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <svg 
                    x-show="isOpen" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 rotate-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0 rotate-0"
                    class="w-5 h-5 absolute inset-0" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </div>
        </button>
        <div x-show="isOpen" x-transition class="pb-3 flex flex-col gap-1">
            @forelse($items as $item)
                <button 
                    @click="{{ $toggleFunction }}({{ $item->id }})"
                    :class="{{ $selectedItemsExpression }}.includes({{ $item->id }}) ? 'text-accent font-medium' : 'text-primary hover:text-accent'"
                    class="text-left text-sm transition-colors cursor-pointer w-max py-1"
                >
                    {{ $item->name }}
                </button>
            @empty
                <p class="text-sm text-subtle py-2">No items available</p>
            @endforelse
        </div>
    </div>
</div>

