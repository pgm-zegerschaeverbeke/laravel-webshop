<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox direction="col" class="gap-8 max-w-4xl mx-auto w-full">
            <!-- Thank You Header with Order Number -->
            @include('order.thank-you.partials.thank-you-header', ['orderNumber' => $orderNumber])

            <!-- Confirmation Email Message -->
            @include('order.thank-you.partials.confirmation-email')
            
            <!-- Order Items -->
            <x-flexbox direction="col" class="gap-4">
                <x-typography.heading as="h2" size="lg" family="serif" weight="bold">
                    Order Details
                </x-typography.heading>
                
                <x-flexbox direction="col" class="gap-3">
                    @foreach($orderItems as $item)
                        @include('order.thank-you.partials.order-item', ['item' => $item])
                    @endforeach
                </x-flexbox>
            </x-flexbox>

            <!-- Order Summary -->
            @include('order.thank-you.partials.order-summary', [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total
            ])

            <!-- Shipping Information -->
            @include('order.thank-you.partials.shipping-info', [
                'shippingName' => $shippingName,
                'shippingEmail' => $shippingEmail,
                'shippingAddress' => $shippingAddress,
                'shippingPostalCode' => $shippingPostalCode,
                'shippingCity' => $shippingCity,
                'shippingCountry' => $shippingCountry,
            ])

            <!-- Action Buttons -->
            @include('order.thank-you.partials.thank-you-actions')
        </x-flexbox>
    </x-flexbox>
</x-layout>

