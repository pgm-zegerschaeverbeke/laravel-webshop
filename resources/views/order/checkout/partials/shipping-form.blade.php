<x-flexbox direction="col" class="gap-4">
    <x-typography.heading as="h2" family="serif" weight="bold">Shipping Information</x-typography.heading>
    
    @guest
        <!-- Name -->
        <x-flexbox direction="col" class="gap-2">
            <label for="name" class="text-primary font-medium">Full Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required
                placeholder="John Doe"
                class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
            >
            @error('name')
                <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
            @enderror
        </x-flexbox>

        <!-- Email -->
        <x-flexbox direction="col" class="gap-2">
            <label for="email" class="text-primary font-medium">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}"
                required
                placeholder="john@example.com"
                class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
            >
            @error('email')
                <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
            @enderror
        </x-flexbox>
    @endguest

    <!-- Address -->
    <x-flexbox direction="col" class="gap-2">
        <label for="address" class="text-primary font-medium">Street Address</label>
        <input 
            type="text" 
            id="address" 
            name="address" 
            value="{{ old('address') }}"
            required
            placeholder="Street and number"
            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
        >
        @error('address')
            <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
        @enderror
    </x-flexbox>

    <!-- Postal Code and City -->
    <x-grid gap="4" size="2">
        <x-flexbox direction="col" class="gap-2">
            <label for="postal_code" class="text-primary font-medium">Postal Code</label>
            <input 
                type="text" 
                id="postal_code" 
                name="postal_code" 
                value="{{ old('postal_code') }}"
                required
                placeholder="1234 AB"
                class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
            >
            @error('postal_code')
                <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
            @enderror
        </x-flexbox>

        <x-flexbox direction="col" class="gap-2">
            <label for="city" class="text-primary font-medium">City</label>
            <input 
                type="text" 
                id="city" 
                name="city" 
                value="{{ old('city') }}"
                required
                placeholder="Amsterdam"
                class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
            >
            @error('city')
                <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
            @enderror
        </x-flexbox>
    </x-grid>

    <!-- Country -->
    <x-flexbox direction="col" class="gap-2">
        <label for="country" class="text-primary font-medium">Country</label>
        <input 
            type="text" 
            id="country" 
            name="country" 
            value="{{ old('country') }}"
            required
            placeholder="Netherlands"
            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
        >
        @error('country')
            <x-typography.paragraph class="text-red-600 text-sm">{{ $message }}</x-typography.paragraph>
        @enderror
    </x-flexbox>
</x-flexbox>

