<article class="c-banner w-100">
    <a href="{{ $link }}">
        <div class="background" style="{{ $styles['background'] }}"></div>
        <div class="overlay" style="{{ $styles['overlay'] }}"></div>
        <div class="foreground">
            {{ $slot }}
        </div>
    </a>
</article>
