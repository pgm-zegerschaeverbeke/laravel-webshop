@props(['product'])

<x-flexbox align="center" justify="between" class="gap-4 px-4"
    x-data="cartData({{ $product->id }})">
    <x-flexbox align="center" class="gap-3">
        <x-button 
            type="button"
            class="!p-4" 
            @click.prevent="decreaseQuantity()"
            x-bind:disabled="quantity <= 1">
            <x-css-math-minus class="w-5 h-5" />
        </x-button>
        <x-typography.paragraph class="text-lg font-bold" x-text="quantity"></x-typography.paragraph>
        <x-button 
            type="button"
            class="!p-4" 
            @click.prevent="increaseQuantity()">
            <x-css-math-plus class="w-5 h-5" />
        </x-button>
    </x-flexbox>
    <x-button 
        type="button"
        @click.prevent="addToCartAction()"
        x-bind:disabled="adding"
        x-text="adding ? 'Adding...' : 'Add to cart'">
        Add to cart
    </x-button>
</x-flexbox>

