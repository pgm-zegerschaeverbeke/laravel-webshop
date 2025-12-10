@props(['name', 'label', 'type' => 'text', 'placeholder' => '', 'required' => false, 'autofocus' => false, 'value' => null])

<x-flexbox direction="col" class="gap-2">
    <label for="{{ $name }}" class="text-primary font-medium">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value ?? old($name) }}"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        placeholder="{{ $placeholder }}"
        class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
    >
    @error($name)
        <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
    @enderror
</x-flexbox>

