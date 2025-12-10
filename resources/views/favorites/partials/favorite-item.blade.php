@props(['product'])

<x-flexbox justify="between" gap="4" class="p-4 border border-subtle rounded-md lg:!flex-row !flex-col" data-favorite-item>
    <x-flexbox direction="row" gap="4" class="flex-1 min-w-0 sm:!flex-row !flex-col">
        <!-- Product Image -->
        <a href="{{ route('products.show', $product->slug) }}" class="flex-shrink-0">
            <img src="{{ asset($product->primary_image_url ?? 'images/placeholder.jpg') }}" 
                 alt="{{ $product->title }}"
                 class="w-24 h-24 object-cover rounded-md">
        </a>
        
        <!-- Product Info -->
        <x-flexbox direction="col" class="gap-2 flex-1 min-w-0">
            <a href="{{ route('products.show', $product->slug) }}" 
                class="hover:text-accent transition-colors">
                <x-typography.heading as="h3" size="lg" class="break-words">{{ $product->title }}</x-typography.heading>
            </a>
            <x-typography.paragraph class="text-subtle text-sm">
                {{ $product->category?->name ?? '' }}{{ $product->category && $product->brand ? ' - ' : '' }}{{ $product->brand?->name ?? '' }}
            </x-typography.paragraph>
            <x-typography.paragraph class="text-xl font-bold text-accent">
                € {{ number_format($product->price, 2, '.', '') }}
            </x-typography.paragraph>
        </x-flexbox>
    </x-flexbox>
    
    <!-- Actions -->
    <x-flexbox direction="col" align="center" class="gap-2 flex-shrink-0 !items-center lg:!items-end w-full lg:w-auto">
        <x-button 
            type="button"
            variant="accent"
            class="!p-4 w-full lg:w-auto"
            data-toggle-favorite
            data-product-id="{{ $product->id }}"
            data-is-favorited="true"
            data-no-toast="true"
            aria-label="Remove from favorites">
            Remove
        </x-button>
        <x-button as="a" href="{{ route('products.show', $product->slug) }}" variant="outline" class="w-full lg:w-auto">
            View Product
        </x-button>
    </x-flexbox>
</x-flexbox>

