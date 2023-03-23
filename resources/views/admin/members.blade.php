<x-front.layout>
    <div class="fluid-container d-flex flex-column h-100 mt-5 p-3 mb-2 member-list">
        <div id="member-filters">
            <h3>Search &amp; Filter</h3>
            <div class="d-flex flex-row justify-content-start">
                <input id="member-search" type="text" class="form-control" placeholder="Search"
                    aria-label="Member Search" />
                <x-input.filter-button :dataObject=$statuses />
                <x-input.filter-button :dataObject=$roles />
                <button type="button" class="btn btn-secondary disabled" id="member-filter-clear">Clear Filters</button>
            </div>
        </div>
        <div id="member-list" class="d-flex flex-row justify-content-start w-100 flex-wrap">
            @foreach ($members as $member)
                <x-admin.member-card :$member />
            @endforeach
        </div>
    </div>
    <script>
        // Error handling for missing images
        document.addEventListener( 'error', (event) => {
            const target = event.target
            if( target.className === 'card-img-top' ) {
                target.setAttribute('src', '/img/profile.png' )
            }
        })
    </script>
</x-front.layout>
