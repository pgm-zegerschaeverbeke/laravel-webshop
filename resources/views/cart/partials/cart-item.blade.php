@props(['item'])

<x-flexbox align="center" justify="between" gap="4" class="p-4 border border-subtle rounded-md lg:!flex-row !flex-col"
    x-data="cartItemData({{ $item['product']->id }}, {{ $item['quantity'] }}, {{ $item['product']->price }})">
    <x-flexbox direction="row" gap="4" class="flex-1 min-w-0 sm:!flex-row !flex-col">
        <!-- Product Image -->
        <a href="{{ route('products.show', $item['product']->slug) }}" class="flex-shrink-0">
            <img src="{{ asset($item['product']->primary_image_url ?? 'images/placeholder.jpg') }}" 
                alt="{{ $item['product']->title }}"
                class="w-24 h-24 object-cover rounded-md">
        </a>
        
        <!-- Product Info -->
        <x-flexbox direction="col" class="gap-2 flex-1 min-w-0">
            <a href="{{ route('products.show', $item['product']->slug) }}" 
                class="hover:text-accent transition-colors">
                <x-typography.heading as="h3" size="lg" class="break-words">{{ $item['product']->title }}</x-typography.heading>
            </a>
            <x-typography.paragraph class="text-subtle text-sm">
                {{ $item['product']->brand?->name ?? '' }}
            </x-typography.paragraph>
            
            <!-- Quantity Controls -->
            <x-flexbox align="center" class="gap-2">
                <span class="text-sm text-subtle">Quantity:</span>
                <x-button 
                    type="button"
                    class="!p-2" 
                    @click.prevent="decreaseQuantity()"
                    x-bind:disabled="quantity <= 1">
                    <x-css-math-minus class="w-4 h-4" />
                </x-button>
                <x-typography.paragraph class="text-base font-bold" x-text="quantity"></x-typography.paragraph>
                <x-button 
                    type="button"
                    class="!p-2" 
                    @click.prevent="increaseQuantity()">
                    <x-css-math-plus class="w-4 h-4" />
                </x-button>
            </x-flexbox>
        </x-flexbox>
    </x-flexbox>                                
    <!-- Price & Remove -->
    <x-flexbox direction="col" align="center" class="gap-2 flex-shrink-0 !items-center lg:!items-end">
        <x-typography.paragraph class="text-xl font-bold">
            € <span x-text="({{ $item['product']->price }} * quantity).toFixed(2)"></span>
        </x-typography.paragraph>
        <x-button 
            type="button"
            variant="outline"
            size="sm"
            @click.prevent="removeItem()"
            class="!p-2 w-fit"
            aria-label="Remove item">
            <x-heroicon-c-x-mark class="w-5 h-5" />
        </x-button>
    </x-flexbox>
</x-flexbox>

