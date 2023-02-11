<x-front.layout>
    <div class="fluid-container d-flex flex-column h-100 mt-5 p-3">
        <div class="row">
            <div class="col-8">
                <h1>{{ $user->name }}</h1>
                <img src="{{ $user->avatar }}" class="img-fluid" alt="{{ $user->name }} Discord profile picture" />
                <hr>
                @include('profile.display', ['user' => $user, 'player' => $player])
            </div>
        </div>
</x-front.layout>
