@props(['orderNumber'])

<!-- Thank You Message -->
<x-flexbox direction="col" align="center" class="gap-4 text-center">
    <x-typography.heading as="h1" family="serif" weight="bold" size="xl" class="text-accent">
        Thank You for Your Purchase!
    </x-typography.heading>
    <x-typography.paragraph class="text-lg text-subtle">
        Your order has been received and is being processed.
    </x-typography.paragraph>
</x-flexbox>

<!-- Order Number -->
<x-flexbox direction="col" class="gap-4 p-6 border border-subtle rounded-md bg-card">
    <x-flexbox justify="between" align="center" class="flex-wrap gap-2">
        <x-typography.paragraph class="text-subtle">Order Number:</x-typography.paragraph>
        <x-typography.heading as="h2" size="lg" family="sans" weight="bold" class="text-accent">
            {{ $orderNumber }}
        </x-typography.heading>
    </x-flexbox>
</x-flexbox>

