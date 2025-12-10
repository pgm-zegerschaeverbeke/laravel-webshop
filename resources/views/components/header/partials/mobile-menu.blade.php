<div x-show="menuOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-x-full opacity-0" 
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-300" 
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0" 
    @click.away="menuOpen = false"
    class="fixed inset-0 bg-background z-[60] lg:hidden" 
    style="display: none;">
    <x-flexbox direction="col" gap="6" class="h-full p-6">
        <!-- Top: Logo/User + Close Button -->
        <div class="relative">
            @auth
                <x-flexbox align="center" gap="3">
                    <x-far-user-circle class="w-10 h-10 text-primary" />
                    <span class="text-primary text-lg font-medium">
                        {{ auth()->user()->first_name ?? auth()->user()->name }}
                    </span>
                </x-flexbox>
            @else
                <a href="{{ route('home') }}" @click="menuOpen = false"
                    class="text-primary text-2xl tracking-wide font-bold">
                    {{ config('app.name', 'Laravel') }}
                </a>
            @endauth

            <x-button @click="menuOpen = false" variant="outline" size="sm" class="absolute top-0 right-0 !p-2"
                aria-label="Close menu">
                <x-heroicon-c-x-mark class="w-6 h-6" />
            </x-button>
        </div>

        <!-- Navigation Links -->
        <x-flexbox as="nav" direction="col" gap="0">
            <a href="{{ route('home') }}" @click="menuOpen = false"
                class="text-primary font-medium hover:text-accent transition-colors duration-300 ease-out text-xl border-t border-subtle py-4">
                Home
            </a>
            <a href="{{ route('products.index') }}" @click="menuOpen = false"
                class="text-primary font-medium hover:text-accent transition-colors duration-300 ease-out text-xl border-t border-subtle py-4">
                Products
            </a>
            <x-flexbox as="a" href="{{ route('cart.index') }}" align="center" gap="3" @click="menuOpen = false"
                class="text-primary font-medium hover:text-accent transition-colors duration-300 ease-out text-xl border-t {{ !auth()->check() ? 'border-b' : '' }} border-subtle py-4">
                <x-css-shopping-bag class="w-7 h-7" />
                <span data-cart-count
                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary text-text-secondary text-sm font-medium">
                    0
                </span>
                <span class="font-medium text-xl">Cart</span>
            </x-flexbox>
            @auth
                <x-flexbox as="a" href="{{ route('favorites.index') }}" align="center" gap="3" @click="menuOpen = false"
                    class="text-primary font-medium hover:text-accent transition-colors duration-300 ease-out text-xl border-t border-b border-subtle py-4">
                    <x-far-heart class="w-7 h-7" />
                    <span data-favorites-count
                        class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary text-text-secondary text-sm font-medium">
                        {{ auth()->user()->favorites()->count() }}
                    </span>
                    <span class="font-medium text-xl">Favourites</span>
                </x-flexbox>
            @endauth
        </x-flexbox>

        <!-- Login/Logout Button -->
        <x-flexbox class="mt-auto">
            @auth
                <form method="POST" action="{{ route('logout') }}" class="w-full" @click="menuOpen = false">
                    @csrf
                    <x-button type="submit" size="md" class="w-full">Logout</x-button>
                </form>
            @else
                <x-button as="a" href="{{ route('login') }}" size="md" class="w-full" @click="menuOpen = false">
                    Log in
                </x-button>
            @endauth
        </x-flexbox>
    </x-flexbox>
</div>

