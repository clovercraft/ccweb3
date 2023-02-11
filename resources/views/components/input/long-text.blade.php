<div {{ $attributes->merge(['class' => 'mb-3 w-25']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea class="form-control" id="{{ $id }}" name="{{ $name }}" rows="3"
        {{ $required ? 'required' : '' }} {{ $showHelp ? "described-by='$name-help'" : '' }}></textarea>
    @if ($showHelp)
        <div id="{{ $name }}-help" class="form-text">{{ $help }}</div>
    @endif
</div>
