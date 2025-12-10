@props([
    'shippingName',
    'shippingEmail',
    'shippingAddress',
    'shippingPostalCode',
    'shippingCity',
    'shippingCountry',
])

<x-flexbox direction="col" class="gap-4">
    <x-typography.heading as="h2" size="lg" family="serif" weight="bold">
        Shipping Information
    </x-typography.heading>
    
    <x-flexbox direction="col" class="gap-3 p-6 border border-subtle rounded-md">
        <x-flexbox direction="col" class="gap-1">
            <x-typography.paragraph class="text-subtle text-sm">Name</x-typography.paragraph>
            <x-typography.paragraph class="font-medium">{{ $shippingName }}</x-typography.paragraph>
        </x-flexbox>
        
        <x-flexbox direction="col" class="gap-1">
            <x-typography.paragraph class="text-subtle text-sm">Email</x-typography.paragraph>
            <x-typography.paragraph class="font-medium">{{ $shippingEmail }}</x-typography.paragraph>
        </x-flexbox>
        
        <x-flexbox direction="col" class="gap-1">
            <x-typography.paragraph class="text-subtle text-sm">Address</x-typography.paragraph>
            <x-flexbox direction="col" class="gap-1">
                <x-typography.paragraph class="font-medium">{{ $shippingAddress }}</x-typography.paragraph>
                <x-typography.paragraph class="font-medium">
                    {{ $shippingPostalCode }} {{ $shippingCity }}
                </x-typography.paragraph>
                <x-typography.paragraph class="font-medium">{{ $shippingCountry }}</x-typography.paragraph>
            </x-flexbox>
        </x-flexbox>
    </x-flexbox>
</x-flexbox>

