<x-layout>
  <x-flexbox as="main" direction="col" class="gap-8 pt-24 pb-12 flex-1">
    @include('products.partials.back-button')
    
    <x-grid gap="4" size="2" as="section">
      @include('products.partials.product-image', ['product' => $product])
      
      <x-flexbox direction="col" justify="between" class="gap-6 border border-subtle rounded-md py-4">
        @include('products.partials.product-header', ['product' => $product])
        @include('products.partials.product-actions', ['product' => $product])
      </x-flexbox>
    </x-grid>
    
    @include('products.partials.related-products', ['relatedProducts' => $relatedProducts])
    
    @include('products.partials.reviews', ['reviews' => $reviews, 'product' => $product])
  </x-flexbox>
</x-layout>