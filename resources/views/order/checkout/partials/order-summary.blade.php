@props([
    'cartItems',
    'subtotal',
    'tax',
    'total',
])

<x-flexbox direction="col" class="gap-4 lg:sticky lg:top-28 lg:self-start">
    <x-flexbox direction="col" class="gap-4 p-6 border border-subtle rounded-md">
        <x-typography.heading as="h2" family="serif" weight="bold">Order Summary</x-typography.heading>
        
        <x-flexbox direction="col" class="gap-3">
            @foreach($cartItems as $item)
                <x-flexbox justify="between" class="gap-4">
                    <x-flexbox direction="col" class="gap-1 flex-1">
                        <x-typography.paragraph class="font-medium">{{ $item['product']->title }}</x-typography.paragraph>
                        <x-typography.paragraph class="text-subtle text-sm">Qty: {{ $item['quantity'] }}</x-typography.paragraph>
                    </x-flexbox>
                    <x-typography.paragraph class="font-medium">€ {{ number_format($item['subtotal'], 2, '.', '') }}</x-typography.paragraph>
                </x-flexbox>
            @endforeach
        </x-flexbox>

        <x-flexbox direction="col" class="gap-3 pt-3 border-t border-subtle">
            <x-flexbox justify="between">
                <x-typography.paragraph class="text-subtle">Subtotal</x-typography.paragraph>
                <x-typography.paragraph class="font-medium">€ {{ number_format($subtotal, 2, '.', '') }}</x-typography.paragraph>
            </x-flexbox>
            
            <x-flexbox justify="between">
                <x-typography.paragraph class="text-subtle">Tax (21%)</x-typography.paragraph>
                <x-typography.paragraph class="font-medium">€ {{ number_format($tax, 2, '.', '') }}</x-typography.paragraph>
            </x-flexbox>
            
            <x-flexbox justify="between" class="pt-3 border-t border-subtle">
                <x-typography.heading as="h3" size="lg" family="sans" weight="bold">Total</x-typography.heading>
                <x-typography.heading as="h3" size="lg" family="sans" weight="bold" class="text-accent">
                    € {{ number_format($total, 2, '.', '') }}
                </x-typography.heading>
            </x-flexbox>
        </x-flexbox>
        
        <x-button type="submit" variant="accent" class="w-full mt-4" id="submit-payment-btn">
            Proceed to Payment
        </x-button>
        
        <x-button as="a" href="{{ route('cart.index') }}" variant="outline" class="w-full">
            Back to Cart
        </x-button>
    </x-flexbox>
</x-flexbox>

