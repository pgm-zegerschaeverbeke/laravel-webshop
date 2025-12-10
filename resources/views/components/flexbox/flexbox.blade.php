@props([
    'as' => 'div',        // html tag: div | section | nav | ul | etc.
    'direction' => 'row', // 'row' | 'col'
    'gap' => null,        // e.g. '2', '4', '6', 'x-4', 'y-8'
    'align' => null,      // 'start' | 'center' | 'end' | 'stretch' | 'baseline'
    'justify' => null,    // 'start' | 'center' | 'end' | 'between' | 'around' | 'evenly'
    'wrap' => false,      // true | false
])

@php
$directionClass = $direction === 'col' ? 'flex-col' : 'flex-row';
$gapClass = $gap ? (Str::startsWith($gap, ['x-', 'y-']) ? 'gap-' . $gap : 'gap-' . $gap) : '';

$alignMap = [
    'start' => 'items-start',
    'center' => 'items-center',
    'end' => 'items-end',
    'stretch' => 'items-stretch',
    'baseline' => 'items-baseline',
];
$justifyMap = [
    'start' => 'justify-start',
    'center' => 'justify-center',
    'end' => 'justify-end',
    'between' => 'justify-between',
    'around' => 'justify-around',
    'evenly' => 'justify-evenly',
];

$wrapClass = $wrap ? 'flex-wrap' : 'flex-nowrap';

$computed = trim(implode(' ', array_filter([
    'flex',
    $directionClass,
    $wrapClass,
    $gapClass,
    $alignMap[$align] ?? null,
    $justifyMap[$justify] ?? null,
])));
@endphp

<{{ $as }} {{ $attributes->class($computed) }}>
    {{ $slot }}
</{{ $as }}>
