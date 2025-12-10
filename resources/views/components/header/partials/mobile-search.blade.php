<div x-show="searchOpen" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-translate-y-full opacity-0" 
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200" 
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="-translate-y-full opacity-0" 
    @click.away="searchOpen = false"
    class="lg:hidden fixed top-[5rem] left-4 right-4 z-40" 
    style="display: none;">
    <div class="rounded-lg shadow-lg" x-data="globalSearch()">
        <x-flexbox align="center" class="gap-2">
            <div class="relative flex-1">
                <input type="search" 
                    placeholder="Search products..." 
                    x-model="searchQuery"
                    @keydown.enter.prevent="handleSearch()" 
                    @input.debounce.500ms="handleSearchInput()" 
                    @focus.stop
                    class="bg-background text-primary placeholder:text-subtle/80 border border-subtle rounded-full px-4 py-2.5 pr-10 w-full focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent [&::-webkit-search-cancel-button]:hidden [&::-ms-clear]:hidden" />
                <button 
                    x-show="searchQuery.length > 0" 
                    @click="searchQuery = ''; handleSearch();" 
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-subtle hover:text-primary transition-colors duration-300"
                    aria-label="Clear search">
                    <x-heroicon-c-x-mark class="w-8 h-8" />
                </button>
            </div>
        </x-flexbox>
    </div>
</div>

