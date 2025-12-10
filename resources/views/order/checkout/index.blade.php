<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox direction="col" class="gap-8">
            <x-typography.heading as="h1" family="serif" weight="bold">Checkout</x-typography.heading>
            
            @if(session('error'))
                <x-flexbox class="bg-red-50 border border-red-200 rounded-md p-4">
                    <x-typography.paragraph class="text-red-600">{{ session('error') }}</x-typography.paragraph>
                </x-flexbox>
            @endif

            <form action="{{ route('checkout.submit') }}" method="POST" class="w-full" id="checkout-form">
                @csrf
                
                <x-grid gap="4" size="2">
                    <!-- Checkout Form -->
                    <x-flexbox direction="col" class="gap-6">
                        @include('order.checkout.partials.shipping-form')
                    </x-flexbox>

                    <!-- Order Summary -->
                    @include('order.checkout.partials.order-summary', [
                        'cartItems' => $cartItems,
                        'subtotal' => $subtotal,
                        'tax' => $tax,
                        'total' => $total,
                    ])
                </x-grid>
            </form>
        </x-flexbox>
    </x-flexbox>
</x-layout>

