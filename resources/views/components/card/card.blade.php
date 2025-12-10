@props([
    'title' => '',
    'image' => '',
    'href' => null,
    'alt' => '',
    'aspect' => 'aspect-[16/10]', // control image ratio
    'category' => null,
    'price' => null,
])

@php
$container = 'h-full flex flex-col border border-subtle rounded-md overflow-hidden hover:translate-y-[-6px] transition-all duration-300 ease-out';
$content = 'px-4 flex-1 min-h-0';
$imageTag = (
    '<div class="'.$aspect.' w-full overflow-hidden">'
    .'<img src="'.e($image).'" alt="'.e($alt ?: $title).'" class="w-full h-full object-cover" />'
    .'</div>'
);

$formattedPrice = is_null($price) ? null : number_format((float) $price, 2);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class($container.' block') }}>
        {!! $imageTag !!}
            <x-flexbox align="stretch" justify="between" class="gap-3 {{ $content }}">
                <x-flexbox direction="col" class="py-4">
                    @if($category)
                        <x-typography.paragraph as="span" class="text-subtle text-xs uppercase tracking-wide">{{ $category }}</x-typography.paragraph>
                    @endif
                    <x-typography.heading as="h3" family="serif" weight="bold">{{ $title }}</x-typography.heading>
                </x-flexbox>
                @if(!is_null($formattedPrice))
                    <div class="self-stretch flex items-center pl-4 border-l border-subtle py-4">
                        <x-typography.paragraph as="span" class="text-primary font-medium whitespace-nowrap">€ {{ $formattedPrice }}</x-typography.paragraph>
                    </div>
                @endif
            </x-flexbox>
    </a>
@else
    <div {{ $attributes->class($container) }}>
        {!! $imageTag !!}
            <x-flexbox align="stretch" justify="between" class="gap-3 {{ $content }}">
                <x-flexbox direction="col" class="py-4">
                    @if($category)
                        <x-typography.paragraph as="span" class="text-subtle text-xs uppercase tracking-wide">{{ $category }}</x-typography.paragraph>
                    @endif
                    <x-typography.heading as="h3" family="serif" weight="bold">{{ $title }}</x-typography.heading>
                </x-flexbox>
                @if(!is_null($formattedPrice))
                    <div class="self-stretch flex items-center pl-4 border-l border-subtle py-4">
                        <x-typography.paragraph as="span" class="text-primary font-medium whitespace-nowrap">€ {{ $formattedPrice }}</x-typography.paragraph>
                    </div>
                @endif
            </x-flexbox>
    </div>
@endif