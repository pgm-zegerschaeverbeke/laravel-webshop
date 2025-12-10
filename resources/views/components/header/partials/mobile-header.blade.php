<x-flexbox direction="row" align="center" justify="between" class="lg:hidden h-16 pr-2">
    @include('components.header.partials.logo')
    
    <x-flexbox align="center" gap="0">
        <!-- Search Icon -->
        <button @click="searchOpen = !searchOpen; menuOpen = false" class="text-primary cursor-pointer p-2">
            <x-heroicon-o-magnifying-glass class="w-8 h-8" />
        </button>

        <!-- Cart Icon -->
        <a href="{{ route('cart.index') }}" class="relative text-primary cursor-pointer p-2">
            <x-css-shopping-bag class="w-8 h-8" />
            <span data-cart-count
                class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary text-text-secondary text-xs font-medium">
                0
            </span>
        </a>

        <!-- Hamburger Menu Button -->
        <button @click="menuOpen = !menuOpen" class="text-primary cursor-pointer p-2" aria-label="Toggle menu">
            <x-heroicon-c-bars-3 class="w-8 h-8" />
        </button>
    </x-flexbox>
</x-flexbox>

