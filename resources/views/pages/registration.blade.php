<x-front.layout>
    <div class="d-flex flex-column h-100 mt-5">
        @if (!$in_guild)
            <div class="container">
                <h1>Hold on</h1>
                <p class="lead">It looks like you haven't joined our Discord server yet. In order to register for our
                    whitelist, you must be a member of the Clovercraft Discord server. Join the server, then try again
                </p>
                <a href="https://discord.gg/clovercraft" target="_blank" class="btn btn-primary mt-3">Join Discord</a>
            </div>
        @else
            <div id="ajaxFormTarget">
                @if ($whitelisted)
                    @include('registration.finished')
                @elseif ($minecraft_verified)
                    @include('registration.verification')
                @else
                    @include('registration.minecraft')
                @endif
            </div>
        @endif
    </div>
</x-front.layout>
