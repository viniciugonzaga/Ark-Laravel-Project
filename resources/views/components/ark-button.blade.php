@props(['href' => null, 'type' => 'button'])
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'ark-btn']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'ark-btn']) }}>
        {{ $slot }}
    </button>
@endif