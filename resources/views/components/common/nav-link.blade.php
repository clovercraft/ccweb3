<a {{ $attributes->merge(['class' => 'navlink']) }} href="{{ $url }}" target="{{ $target }}">
    @empty($icon)
        {{ $slot }}
    @else
        <i class="{{ $icon }}"></i>
        <span class="sr-only">{{ $srtext }}</span>
    @endempty
</a>
