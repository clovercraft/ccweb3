<div class="dropdown filter-button" id="{{ $id }}">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $label }}
    </button>
    <ul class="dropdown-menu">
        @foreach ($options as $value => $text)
            <li><a class="dropdown-item" data-value="{{ $value }}">{{ $text }}</a></li>
        @endforeach
    </ul>
</div>
