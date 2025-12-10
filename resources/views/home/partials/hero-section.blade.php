<x-grid as="section" gap="3" size="2">
    <!-- Left: Large image -->
    <div class="h-full md:h-[calc(100vh-7rem)] overflow-hidden rounded-md">
        <img src="{{ asset('storage/images/scam-large.webp') }}" alt="Placeholder left"
            class="w-full h-full object-cover" />
    </div>

    <!-- Right: Text on top, image below -->
    <x-flexbox direction="col" class="gap-3 h-full md:h-[calc(100vh-7rem)]">
        <div class="bg-background rounded-md flex flex-col justify-between flex-1 py-4 pt-6 gap-3">
            <x-typography.paragraph as="span" class="uppercase tracking-wider text-sm text-accent">
                Scamming has never been so easy
            </x-typography.paragraph>
            <x-typography.heading as="h1" family="serif" weight="bold">
                Scams So Good, They'll Want to Get Fooled Twice
            </x-typography.heading>
            <x-button as="a" href="{{ route('products.index') }}" class="mt-6 w-max">
                View Products
            </x-button>
        </div>
        <div class="flex-1 overflow-hidden rounded-md">
            <img src="{{ asset('storage/images/scam-small.webp') }}" alt="Placeholder right bottom"
                class="w-full h-full object-cover" />
        </div>
    </x-flexbox>
</x-grid>

