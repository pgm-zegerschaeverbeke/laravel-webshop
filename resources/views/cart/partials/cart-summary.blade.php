@props(['subtotal'])

<x-flexbox direction="col" class="gap-4 lg:sticky lg:top-28 lg:self-start"
    x-data="orderSummary({{ $subtotal }})"
    @cart-item-updated.window="updateTotals()">
    <x-flexbox direction="col" class="gap-4 p-6 border border-subtle rounded-md">
        <x-typography.heading as="h2" size="lg" family="serif" weight="bold">Order Summary</x-typography.heading>
        
        <x-flexbox direction="col" class="gap-3">
            <x-flexbox justify="between">
                <x-typography.paragraph class="text-subtle">Subtotal</x-typography.paragraph>
                <x-typography.paragraph class="font-medium" 
                    x-text="'€ ' + subtotal.toFixed(2)">
                    € {{ number_format($subtotal, 2, '.', '') }}
                </x-typography.paragraph>
            </x-flexbox>
            
            <x-flexbox justify="between">
                <x-typography.paragraph class="text-subtle">Tax (21%)</x-typography.paragraph>
                <x-typography.paragraph class="font-medium" 
                    x-text="'€ ' + tax.toFixed(2)">
                    € {{ number_format($subtotal * 0.21, 2, '.', '') }}
                </x-typography.paragraph>
            </x-flexbox>
            
            <x-flexbox justify="between" class="pt-3 border-t border-subtle">
                <x-typography.heading as="h3" size="lg" family="sans" weight="bold">Total</x-typography.heading>
                <x-typography.heading as="h3" size="lg" family="sans" weight="bold" class="text-accent"
                    x-text="'€ ' + total.toFixed(2)">
                    € {{ number_format($subtotal * 1.21, 2, '.', '') }}
                </x-typography.heading>
            </x-flexbox>
        </x-flexbox>
        
        <x-button as="a" href="{{ route('checkout.index') }}" variant="accent" class="w-full mt-4">
            Proceed to Checkout
        </x-button>
        
        <x-button as="a" href="{{ route('products.index') }}" variant="outline" class="w-full">
            Continue Shopping
        </x-button>
    </x-flexbox>
</x-flexbox>

