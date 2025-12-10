<x-layout>
    <x-flexbox as="main" direction="col" class="gap-12 pt-24 pb-12 flex-1">
        @include('home.partials.hero-section')
        @include('home.partials.featured-products', ['featured' => $featured])
    </x-flexbox>
</x-layout>

