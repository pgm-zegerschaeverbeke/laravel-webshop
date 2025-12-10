@props(['item'])

<x-flexbox align="center" justify="between" gap="4" 
    class="p-4 border border-subtle rounded-md">
    <x-flexbox direction="col" class="gap-1 flex-1">
        <x-typography.heading as="h3" size="md" family="sans">
            {{ $item['title'] }}
        </x-typography.heading>
        <x-typography.paragraph class="text-subtle text-sm">
            Quantity: {{ $item['quantity'] }} × €{{ number_format($item['price'], 2, '.', '') }}
        </x-typography.paragraph>
    </x-flexbox>
    <x-typography.paragraph class="text-xl font-bold">
        €{{ number_format($item['subtotal'], 2, '.', '') }}
    </x-typography.paragraph>
</x-flexbox>

