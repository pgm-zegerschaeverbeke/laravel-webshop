@props(['name', 'label', 'placeholder' => '', 'required' => false, 'showPasswordVar' => 'showPassword'])

<x-flexbox direction="col" class="gap-2">
    <label for="{{ $name }}" class="text-primary font-medium">{{ $label }}</label>
    <x-flexbox align="center" class="relative">
        <input
            type="password"
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            placeholder="{{ $placeholder }}"
            x-bind:type="{{ $showPasswordVar }} ? 'text' : 'password'"
            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent w-full"
        >
        <button
            type="button"
            @click="{{ $showPasswordVar }} = !{{ $showPasswordVar }}"
            class="absolute right-3 text-accent-dark hover:opacity-80 transition-opacity"
            aria-label="Toggle password visibility"
        >
            <!-- Eye icon (show password) -->
            <svg x-show="{{ $showPasswordVar }}" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            </svg>
            <!-- Eye slash icon (hide password) -->
            <svg x-show="!{{ $showPasswordVar }}" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        </button>
    </x-flexbox>
    @error($name)
        <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
    @enderror
</x-flexbox>

