@props(['relatedProducts'])

<x-flexbox as="section" direction="col" class="gap-8 pb-6">
    <x-flexbox direction="col">
        <x-typography.paragraph as="span" class="text-accent text-sm uppercase">
            You might also like
        </x-typography.paragraph>
        <x-typography.heading as="h2" family="serif" weight="bold">
            Related products
        </x-typography.heading>
    </x-flexbox>

    <x-grid gap="4" size="3">
        @forelse($relatedProducts as $relatedProduct)
            <x-card.card 
                :title="$relatedProduct->title" 
                :image="asset($relatedProduct->primary_image_url ?? 'images/placeholder.jpg')" 
                :href="route('products.show', $relatedProduct->slug)"
                :category="$relatedProduct->category->name ?? ''" 
                :price="$relatedProduct->price" />
        @empty
            <x-typography.paragraph class="text-subtle">
                No related products found.
            </x-typography.paragraph>
        @endforelse
    </x-grid>
</x-flexbox>

