@props(['product'])

<x-flexbox direction="col" class="gap-4 px-4">
    <x-flexbox align="center" justify="between" class="gap-2">
        <x-typography.paragraph as="span"
            class="text-subtle text-xs uppercase tracking-wide">
            {{ $product->category?->name }} - {{ $product->brand?->name }}
        </x-typography.paragraph>
        @auth
            @php
                $isFavorited = auth()->user()->favorites()->where('product_id', $product->id)->exists();
            @endphp
            <x-button 
                type="button"
                variant="{{ $isFavorited ? 'accent' : 'primary' }}"
                data-toggle-favorite
                data-product-id="{{ $product->id }}"
                data-is-favorited="{{ $isFavorited ? 'true' : 'false' }}">
                <x-far-heart class="w-5 h-5" />
            </x-button>
        @endauth
    </x-flexbox>
    <x-typography.heading as="h1" family="serif" weight="bold">
        {{ $product->title }}
    </x-typography.heading>
    <x-typography.paragraph>
        {{ $product->description }}
    </x-typography.paragraph>
    <x-typography.paragraph class="text-xl font-bold text-right">
        € {{ $product->price }}
    </x-typography.paragraph>
</x-flexbox>

