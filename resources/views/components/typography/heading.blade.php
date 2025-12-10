@props([
    'as' => 'h2',           // h1|h2|h3|h4|h5|h6
    'color' => 'primary',   // e.g., 'primary', 'text-secondary', 'accent'
    'weight' => 'semibold', // light|normal|medium|semibold|bold|extrabold
    'family' => 'serif',    // sans|serif
])

@php
$sizeByLevel = [
    'h1' => 'text-4xl sm:text-5xl md:text-6xl lg:text-7xl',
    'h2' => 'text-3xl sm:text-5xl md:text-4xl lg:text-5xl',
    'h3' => 'text-2xl sm:text-4xl md:text-3xl lg:text-4xl',
    'h4' => 'text-xl sm:text-3xl md:text-2xl lg:text-3xl',
    'h5' => 'text-lg sm:text-2xl md:text-xl lg:text-2xl',
    'h6' => 'text-base sm:text-xl md:text-lg lg:text-xl',
];
$weightMap = [
    'extralight' => 'font-extralight',
    'light' => 'font-light',
    'normal' => 'font-normal',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
    'extrabold' => 'font-extrabold',
];
$familyMap = [
    'sans' => 'font-sans',
    'serif' => 'font-serif',
];

$tag = array_key_exists($as, $sizeByLevel) ? $as : 'h2';
$computed = trim(implode(' ', [
    $sizeByLevel[$tag],
    $familyMap[$family] ?? $familyMap['serif'],
    $weightMap[$weight] ?? $weightMap['semibold'],
    // allow passing any tailwind color token, e.g., 'primary', 'accent', 'text-secondary'
    Str::startsWith($color, 'text-') ? $color : ('text-' . $color),
    'tracking-tight',
]));
@endphp

<{{ $tag }} {{ $attributes->class($computed) }}>
    {{ $slot }}
</{{ $tag }}>
