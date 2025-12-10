<x-flexbox direction="row" align="center" justify="between" class="hidden lg:flex h-16 gap-4">
    @include('components.header.partials.logo')

    <x-flexbox align="center" justify="center" class="flex-1 gap-4">
        @include('components.header.partials.desktop-nav')
        @include('components.header.partials.desktop-search')
    </x-flexbox>

    @include('components.header.partials.desktop-actions')
</x-flexbox>

