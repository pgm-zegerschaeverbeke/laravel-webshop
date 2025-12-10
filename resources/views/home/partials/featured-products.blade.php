@props(['featured'])

<x-flexbox as="section" direction="col" class="gap-8">
    <x-flexbox direction="col">
        <x-typography.paragraph as="span" class="text-accent text-sm uppercase">
            Hottest scams right now!
        </x-typography.paragraph>
        <x-typography.heading as="h2" family="serif" weight="bold">
            Featured scams
        </x-typography.heading>
    </x-flexbox>

    <x-grid gap="4" size="3">
        @foreach($featured as $item)
            <x-card.card
                :title="$item->title"
                :image="asset($item->primary_image_url ?? 'images/placeholder.jpg')"
                :href="route('products.show', $item->slug)"
                :category="$item->category?->name ?? ''"
                :price="$item->price"
            />
        @endforeach
    </x-grid>
</x-flexbox>

