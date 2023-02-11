<div {{ $attributes->merge(['class' => 'mb-3 w-25']) }}>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select class="form-select" id="{{ $id }}" name="{{ $name }}" {{ $required ? 'required' : '' }}
        {{ $showHelp ? "described-by='$name-help'" : '' }}>
        @foreach ($options as $val => $text)
            <option value="{{ $val }}" {{ $val === $selected ? 'selected' : '' }}>{{ $text }}</option>
        @endforeach
    </select>
    @if ($showHelp)
        <div id="{{ $name }}-help" class="form-text">{{ $help }}</div>
    @endif
</div>
