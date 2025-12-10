<x-flexbox direction="col" class="gap-3 sm:flex-row">
    <x-button as="a" href="{{ route('products.index') }}" variant="accent" class="flex-1">
        Continue Shopping
    </x-button>
    <x-button as="a" href="{{ route('home') }}" variant="outline" class="flex-1">
        Back to Home
    </x-button>
</x-flexbox>

