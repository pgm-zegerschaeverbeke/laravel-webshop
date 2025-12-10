@props(['categories', 'brands'])

<x-flexbox as="aside" direction="col" class="w-full md:w-64" gap="4">
    <x-flexbox align="center" justify="between">
        <x-typography.paragraph as="span" class="text-accent text-lg font-medium uppercase">
            Filters
        </x-typography.paragraph>
        <button 
            @click="clearFilters()" 
            type="button"
            class="text-xs font-medium uppercase border border-subtle hover:bg-text-secondary rounded-full px-2 py-1 transition-colors duration-300 ease-out cursor-pointer"
            x-show="selectedCategories.length > 0 || selectedBrands.length > 0"
        >
            Clear
        </button>
    </x-flexbox>
    <x-flexbox direction="col" class="gap-0">
        <x-accordion.filter-accordion 
            title="Categories"
            :items="$categories"
            selected-items-expression="selectedCategories"
            toggle-function="toggleCategory"
            storage-key="filterAccordionCategory"
        />
        <x-accordion.filter-accordion 
            title="Brands"
            :items="$brands"
            selected-items-expression="selectedBrands"
            toggle-function="toggleBrand"
            storage-key="filterAccordionBrand"
        />
    </x-flexbox>
</x-flexbox>

