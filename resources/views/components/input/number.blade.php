<div {{ $attributes->merge(['class' => 'mb-3 w-25']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input class="form-control" type="number" id="{{ $id }}" name="{{ $name }}"
        {{ $required ? 'required' : '' }} {{ $showHelp ? "described-by='$name-help'" : '' }} />
    @if ($showHelp)
        <div id="{{ $name }}-help" class="form-text">{{ $help }}</div>
    @endif
</div>
