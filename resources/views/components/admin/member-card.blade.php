<article class="card member-card" id="member-card-{{ $uuid }}" data-uuid="{{ $uuid }}"
    data-id="{{ $id }}" data-name="{{ $name }}" data-role="{{ $roleSlug }}"
    data-status="{{ $status }}">
    <img src="{{ $avatar }}" class="card-img-top" alt="{{ $name }}" />
    <div class="card-header">
        <strong>{{ $name }}</strong> | {{ $role }}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Status</strong> {{ $status }}</li>
    </ul>
    <div class="card-body">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Manage
            </button>
            <ul class="dropdown-menu member-actions">
                @foreach ($actions as $name => $path)
                    <li><a class="dropdown-item" href="{{ $path }}">{{ $name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</article>
