@props(['subtotal', 'tax', 'total'])

<x-flexbox direction="col" class="gap-3 p-6 border border-subtle rounded-md">
    <x-flexbox justify="between">
        <x-typography.paragraph class="text-subtle">Subtotal</x-typography.paragraph>
        <x-typography.paragraph class="font-medium">
            €{{ number_format($subtotal, 2, '.', '') }}
        </x-typography.paragraph>
    </x-flexbox>
    
    <x-flexbox justify="between">
        <x-typography.paragraph class="text-subtle">Tax (21%)</x-typography.paragraph>
        <x-typography.paragraph class="font-medium">
            €{{ number_format($tax, 2, '.', '') }}
        </x-typography.paragraph>
    </x-flexbox>
    
    <x-flexbox justify="between" class="pt-3 border-t border-subtle">
        <x-typography.heading as="h3" size="lg" family="sans" weight="bold">Total</x-typography.heading>
        <x-typography.heading as="h3" size="lg" family="sans" weight="bold" class="text-accent">
            €{{ number_format($total, 2, '.', '') }}
        </x-typography.heading>
    </x-flexbox>
</x-flexbox>

