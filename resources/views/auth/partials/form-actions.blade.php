@props(['submitText', 'alternateText', 'alternateRoute', 'alternateButtonText'])

<x-button type="submit" variant="accent" class="w-full">
    {{ $submitText }}
</x-button>

<x-flexbox align="center" justify="center" class="gap-2">
    <x-typography.paragraph class="text-subtle text-sm">
        {{ $alternateText }}
    </x-typography.paragraph>
    <x-button as="a" href="{{ route($alternateRoute) }}" variant="outline" size="sm">
        {{ $alternateButtonText }}
    </x-button>
</x-flexbox>

