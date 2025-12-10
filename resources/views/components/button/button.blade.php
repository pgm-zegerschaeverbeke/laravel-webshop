@props([
    'variant' => 'primary', // primary | accent | outline
    'size' => 'md',        // sm | md | lg
    'as' => 'button',      // button | a
    'href' => null,
])

@php
$classMap = [
    'base' => 'inline-flex items-center justify-center rounded-full font-medium select-none transition-all duration-300 ease-out cursor-pointer',
    'variant' => [
        'primary' => 'bg-primary text-text-secondary hover:bg-text-secondary hover:text-primary',
        'accent' => 'bg-accent text-text-secondary hover:bg-accent-dark',
        'outline' => 'bg-transparent text-primary border border-subtle hover:bg-primary hover:text-text-secondary',
    ],
    'size' => [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-3 text-lg',
    ],
];

$classes = $classMap['base'].' '
    .$classMap['variant'][$variant].' '
    .$classMap['size'][$size];
@endphp

@if($as === 'a' && $href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
