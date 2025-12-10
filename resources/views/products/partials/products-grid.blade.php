@if($products->count() > 0)
    <x-grid gap="4" size="3lg">
        @foreach($products as $product)
        <x-card.card :title="$product->title" :image="asset($product->primary_image_url ?? 'images/placeholder.jpg')" :href="route('products.show', $product->slug)"
            :category="$product->category?->name ?? ''"
            :price="$product->price"
        />
        @endforeach
    </x-grid>
@else
    <div class="flex-1 flex items-center justify-center py-12">
        <x-typography.paragraph class="text-center text-subtle text-lg">
            No items match your filters.
        </x-typography.paragraph>
    </div>
@endif

