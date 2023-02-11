@if ($display)
    <nav id="member" class="d-flex flex-column justify-content-start">
        @foreach ($links as $route => $text)
            <x-common.nav-link url="{{ route($route) }}">{{ $text }}</x-common.nav-link>
        @endforeach
    </nav>
@endif
