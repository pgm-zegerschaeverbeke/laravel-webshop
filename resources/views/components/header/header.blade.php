<div x-data="{ menuOpen: false, searchOpen: false }" class="w-full fixed top-2 left-0 right-0 z-50 px-4">
    <header>
        <div class="mx-auto pl-4 bg-background border border-subtle rounded-lg">
            @include('components.header.partials.desktop-layout')
            @include('components.header.partials.mobile-header')
        </div>
    </header>

    @include('components.header.partials.mobile-search')
    @include('components.header.partials.mobile-menu')
</div>