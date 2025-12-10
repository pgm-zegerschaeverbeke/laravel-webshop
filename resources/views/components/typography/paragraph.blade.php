@props([
    'as' => 'p',          // allow span/div if desired
])

@php
$tag = in_array($as, ['p','span','div']) ? $as : 'p';
@endphp

<{{ $tag }} {{ $attributes }}>
    {{ $slot }}
</{{ $tag }}>
