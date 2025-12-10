<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox direction="col" class="gap-8">
            <x-typography.heading as="h1" family="serif" weight="bold">Shopping Cart</x-typography.heading>
            
            @if(empty($cartItems))
                <x-flexbox direction="col" align="center" class="gap-4 py-12 border border-subtle rounded-md">
                    <x-typography.paragraph class="text-subtle text-lg">Your cart is empty</x-typography.paragraph>
                    <x-button as="a" href="{{ route('products.index') }}">Continue Shopping</x-button>
                </x-flexbox>
            @else
                <x-grid gap="4" size="3">
                    <!-- Cart Items -->
                    <x-flexbox direction="col" class="gap-4 lg:col-span-2">
                        @foreach($cartItems as $item)
                            @include('cart.partials.cart-item', ['item' => $item])
                        @endforeach
                    </x-flexbox>
                    
                    <!-- Order Summary -->
                    @include('cart.partials.cart-summary', ['subtotal' => $subtotal])
                </x-grid>
            @endif
        </x-flexbox>
    </x-flexbox>
</x-layout>
