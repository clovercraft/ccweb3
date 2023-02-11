<!-- #Component App\View\Extras\Extras -->
@foreach ($extras as $component)
    <!-- #Component {{ $component['name'] }} -->
    {!! $component['html'] !!}
    <!-- #End {{ $component['name'] }} -->
@endforeach
<!-- #End App\View\Extras\Extras -->
