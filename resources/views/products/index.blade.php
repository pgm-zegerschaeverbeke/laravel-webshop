<x-layout>
    <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
        <x-flexbox as="section" direction="col" class="gap-24 border-b pb-4">
            <x-typography.heading as="h1" family="serif" weight="extralight" class="!text-7xl md:!text-9xl text-center w-full">All Our
                Products</x-typography.heading>
            <x-typography.paragraph as="span" class="text-lg uppercase mb-2" data-product-count="{{ $products->total() }}" id="product-count-display">
                {{ $products->total() }} Products
            </x-typography.paragraph>

        </x-flexbox>
        <x-flexbox as="section" direction="col" class="gap-6 md:flex-row" x-data="productFilter()" data-products-route="{{ route('products.index') }}" x-ref="filterSection">
            @include('products.partials.filters', ['categories' => $categories, 'brands' => $brands])
            
            <div class="flex-1">
                <div id="products-container">
                    @include('products.partials.products-grid', ['products' => $products])
                </div>
            </div>
        </x-flexbox>

        <div id="pagination-container" class="w-full flex justify-center">
            @include('products.partials.pagination', ['products' => $products])
        </div>

    </x-flexbox>
</x-layout>