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
                <div class="container mt-5">
                    <h1>Your logged in!</h1>
                    <h2>We just need a couple more details to set up your account.</h2>
                    <form method="POST" action="{{ route('validation.profile') }}">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <label for="input-birthdate">Birthday</label>
                        <input type="date" id="input-birthdate" name="birthdate" class="form-control mb-2" />
                        <label for="input-pronouns">Pronouns</label>
                        <input type="text" id="input-pronouns" name="pronouns" class="form-control mb-2" />
                        <button class="btn btn-primary" type="submit">Finish</button>
                    </form>
                </div>

            </div>
        @endif
    </div>
</x-front.layout>
