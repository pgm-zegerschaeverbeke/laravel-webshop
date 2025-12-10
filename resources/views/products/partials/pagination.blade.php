@if($products->total() > 0 && $products->hasPages())
    <div class="w-full flex justify-center">
        {{ $products->links() }}
    </div>
@endif

