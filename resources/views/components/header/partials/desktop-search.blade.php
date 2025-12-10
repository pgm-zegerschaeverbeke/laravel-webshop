<x-flexbox align="center" class="gap-1" x-data="globalSearch()">
    <x-heroicon-o-magnifying-glass class="w-6 h-6 text-primary" />
    <div class="hidden sm:block relative">
        <input type="search" 
            placeholder="Search" 
            x-model="searchQuery"
            @keydown.enter.prevent="handleSearch()" 
            @input.debounce.500ms="handleSearchInput()"
            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-full px-3 py-1.5 pr-8 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent w-56 [&::-webkit-search-cancel-button]:hidden [&::-ms-clear]:hidden" />
        <button 
            x-show="searchQuery.length > 0" 
            @click="searchQuery = ''; handleSearch();"
            type="button"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-subtle hover:text-primary transition-colors duration-300"
            aria-label="Clear search">
            <x-heroicon-c-x-mark class="w-6 h-6" />
        </button>
    </div>
</x-flexbox>

