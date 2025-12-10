@props([
    'as' => 'div',     // wrapper tag
    'gap' => '6',      // Tailwind gap scale (e.g. '4', '6', '8') or 'x-4', 'y-2'
    'size' => null,     // grid size (e.g. 1, 2, 3, 4) - uses Tailwind breakpoints
])

@php
$sizeMap = [
    '1' => 'grid-cols-1',
    '2' => 'grid-cols-1 lg:grid-cols-2',
    '3' => 'grid-cols-1 lg:grid-cols-2 xl:grid-cols-3',
    '3lg' => 'grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3',
];
$gapClass = $gap ? (Str::startsWith($gap, ['x-', 'y-']) ? 'gap-' . $gap : 'gap-' . $gap) : '';

if ($size && isset($sizeMap[$size])) {
    $computed = trim(implode(' ', array_filter([
        'grid',
        $gapClass,
        $sizeMap[$size],
    ])));
} else {
    // Simple grid without column specification
    $computed = trim(implode(' ', array_filter([
        'grid',
        $gapClass,
    ])));
}
@endphp

<{{ $as }} {{ $attributes->class($computed) }}>
    {{ $slot }}
</{{ $as }}>
