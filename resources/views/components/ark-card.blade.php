@props(['href' => null, 'title' => null, 'image' => null])
@php
    $isLink = !is_null($href);
    $tag = $isLink ? 'a' : 'div';
@endphp

<{{ $tag }} @if($isLink) href="{{ $href }}" @endif {{ $attributes->merge(['class' => 'ark-card']) }}>
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="max-w-full max-h-40 object-contain mb-4 filter grayscale brightness-75 transition-all duration-300 group-hover:filter-none group-hover:scale-110">
    @endif
    @if($title)
        <h2 class="text-xl font-display font-bold mb-2 text-transparent bg-gradient-to-r from-cyan-100 to-gray-300 bg-clip-text">{{ $title }}</h2>
    @endif
    <div class="text-gray-300">
        {{ $slot }}
    </div>
</{{ $tag }}>