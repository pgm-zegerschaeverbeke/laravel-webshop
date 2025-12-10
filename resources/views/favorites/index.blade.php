<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox direction="col" class="gap-8">
            <x-typography.heading as="h1" family="serif" weight="bold">Favorites</x-typography.heading>
            
            @if($favorites->isEmpty())
                <x-flexbox direction="col" align="center" class="gap-4 py-12 border border-subtle rounded-md">
                    <x-typography.paragraph class="text-subtle text-lg">You haven't favorited any products yet</x-typography.paragraph>
                    <x-button as="a" href="{{ route('products.index') }}">Browse Products</x-button>
                </x-flexbox>
            @else
                <x-flexbox direction="col" class="gap-4" data-favorites-list>
                    @foreach($favorites as $product)
                        @include('favorites.partials.favorite-item', ['product' => $product])
                    @endforeach
                </x-flexbox>
            @endif
        </x-flexbox>
    </x-flexbox>
</x-layout>

