@props(['product'])

<img src="{{ asset($product->primary_image_url ?? 'images/placeholder.jpg') }}" 
     alt="{{ $product->title }}"
     class="rounded-md object-cover h-full w-full aspect-[16/10] lg:aspect-[1/1] max-h-[calc(100vh-16rem)]">

