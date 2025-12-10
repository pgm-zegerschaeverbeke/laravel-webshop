<x-flexbox align="center" class="h-full">
    @auth
        <x-flexbox as="a" href="{{ route('favorites.index') }}" align="center"
            class="gap-2 hover:bg-text-secondary transition-all duration-300 ease-out h-full px-4 border-l border-subtle">
            <x-far-heart class="w-7 h-7" />
            <span data-favorites-count
                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary text-text-secondary text-sm font-medium">
                {{ auth()->user()->favorites()->count() }}
            </span>
        </x-flexbox>
    @endauth

    <x-flexbox as="a" href="{{ route('cart.index') }}" align="center"
        class="gap-2 hover:bg-text-secondary transition-all duration-300 ease-out h-full px-4 border-l border-subtle">
        <x-css-shopping-bag class="w-7 h-7" />
        <span data-cart-count
            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary text-text-secondary text-sm font-medium">
            0
        </span>
    </x-flexbox>

    <div class="relative h-full border-l border-subtle">
        @auth
            <x-flexbox align="center" gap="3" class="h-full px-4">
                <x-flexbox align="center" gap="2">
                    <x-far-user-circle class="w-7 h-7" />
                    <span class="text-primary font-medium">
                        {{ auth()->user()->first_name ?? auth()->user()->name }}
                    </span>
                </x-flexbox>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button type="submit" class="!p-3">
                        <x-fas-sign-out-alt class="w-5 h-5" />
                    </x-button>
                </form>
            </x-flexbox>
        @else
            <x-flexbox align="center" gap="2" class="h-full px-4">
                <x-button as="a" href="{{ route('login') }}" size="md">Log in</x-button>
            </x-flexbox>
        @endauth
    </div>
</x-flexbox>

