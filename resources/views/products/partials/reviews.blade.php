@props(['reviews', 'product'])

<x-flexbox as="section" direction="col" class="gap-6 pb-6" id="reviews">
    <x-flexbox direction="col">
        <x-typography.paragraph as="span" class="text-accent text-sm uppercase">
            Customer Reviews
        </x-typography.paragraph>
        <x-typography.heading as="h2" family="serif" weight="bold">
            Reviews
        </x-typography.heading>
    </x-flexbox>

    <!-- Review Form or Login Message -->
    @auth
        <x-flexbox direction="col" class="gap-4 p-4 border border-subtle rounded-md">
            <x-typography.heading as="h3" size="md" family="sans" weight="bold">
                Write a Review
            </x-typography.heading>
            
            @if(session('success'))
                <x-flexbox class="gap-2 p-3 bg-green-100/50 border border-green-300 rounded-md">
                    <x-typography.paragraph class="text-green-800">{{ session('success') }}</x-typography.paragraph>
                </x-flexbox>
            @endif

            @if($errors->any())
                <x-flexbox direction="col" class="gap-2 p-3 bg-red-100/50 border border-red-300 rounded-md">
                    @foreach($errors->all() as $error)
                        <x-typography.paragraph class="text-red-800">{{ $error }}</x-typography.paragraph>
                    @endforeach
                </x-flexbox>
            @endif

            <form method="POST" action="{{ route('reviews.store') }}" class="w-full" x-data="{ rating: 0 }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <x-flexbox direction="col" gap="4">
                    <!-- Rating -->
                    <x-flexbox direction="col" class="gap-2">
                        <x-typography.paragraph class="text-primary font-medium">Rating</x-typography.paragraph>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button 
                                    type="button"
                                    @click="rating = {{ $i }}"
                                    class="text-2xl cursor-pointer transition-colors"
                                    :class="rating >= {{ $i }} ? 'text-accent' : 'text-subtle'"
                                >
                                    ★
                                </button>
                            @endfor
                            <input type="hidden" name="rating" x-model="rating" required>
                        </div>
                    </x-flexbox>

                    <!-- Title -->
                    <x-flexbox direction="col" class="gap-2">
                        <label for="review_title" class="text-primary font-medium">Title</label>
                        <input 
                            type="text" 
                            id="review_title" 
                            name="title" 
                            required
                            placeholder="Give your review a title"
                            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent"
                        >
                    </x-flexbox>

                    <!-- Body -->
                    <x-flexbox direction="col" class="gap-2">
                        <label for="review_body" class="text-primary font-medium">Review</label>
                        <textarea 
                            id="review_body" 
                            name="body" 
                            rows="4"
                            placeholder="Share your thoughts about this product..."
                            class="bg-card text-primary placeholder:text-subtle/80 border border-subtle rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-accent/30 focus:border-accent resize-none"
                        ></textarea>
                    </x-flexbox>

                    <!-- Submit Button -->
                    <x-button type="submit" size="md">Submit Review</x-button>
                </x-flexbox>
            </form>
        </x-flexbox>
    @else
        <x-flexbox direction="col" align="center" class="gap-4 p-4 border border-subtle rounded-md">
            <x-typography.paragraph class="text-subtle text-lg text-center">
                Please log in to post a review
            </x-typography.paragraph>
            <x-button as="a" href="{{ route('login') }}" size="md">Log in</x-button>
        </x-flexbox>
    @endauth

    @if($reviews->isEmpty())
        <x-flexbox direction="col" align="center" class="gap-4 py-12 border border-subtle rounded-md">
            <x-typography.paragraph class="text-subtle text-lg">
                No reviews yet. Be the first to review this product!
            </x-typography.paragraph>
        </x-flexbox>
    @else
        <x-flexbox direction="col" class="gap-4">
            @foreach($reviews as $review)
                <x-flexbox direction="col" class="gap-3 p-4 border border-subtle rounded-md">
                    <x-flexbox justify="between" align="start" class="gap-4 flex-wrap">
                        <x-flexbox direction="col" class="gap-1">
                            <x-typography.heading as="h3" size="md" family="sans" weight="bold">
                                {{ $review->title ?? 'Review' }}
                            </x-typography.heading>
                            <x-flexbox align="center" gap="2">
                                <x-flexbox class="gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <span class="text-{{ $i <= $review->rating ? 'accent' : 'subtle' }}">
                                        ★
                                    </span>
                                    @endfor
                                </x-flexbox>
                                <x-typography.paragraph class="text-subtle text-sm">
                                    @php
                                        $userName = trim(($review->user->first_name ?? '') . ' ' . ($review->user->last_name ?? '')) 
                                            ?: ($review->user->name ?? $review->user->email ?? 'Anonymous');
                                    @endphp
                                    {{ $userName }}
                                </x-typography.paragraph>
                            </x-flexbox>
                        </x-flexbox>
                        <x-typography.paragraph class="text-subtle text-sm">
                            {{ $review->created_at->format('M d, Y') }}
                        </x-typography.paragraph>
                    </x-flexbox>
                    
                    @if($review->body)
                        <x-typography.paragraph class="text-primary">
                            {{ $review->body }}
                        </x-typography.paragraph>
                    @endif
                </x-flexbox>
            @endforeach
        </x-flexbox>
        
        @if($reviews->hasPages())
            <div class="w-full flex justify-center mt-4">
                {{ $reviews->links() }}
            </div>
        @endif
    @endif
</x-flexbox>

