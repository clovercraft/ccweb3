<div class="container mt-5">
    <h1>Hello, {{ $authuser->name }}!</h1>
    <h2>We've verified that you are a member of the Clovercraft Discord server. Now we need to verify your Minecraft
        account.</h2>
    <p>Please enter your Minecraft username below. This needs to be your in-game handle, not your gamertag. If you do
        not want to join our whitelist at this time, you may opt-out of the registration process.</p>
    <input type="text" id="input-username" name="username" class="form-control mb-2" />
    <input type="hidden" id="input-user" name="user" value="{{ $authuser->id }}" />
    <button class="btn btn-primary" id="submit-minecraft">Verify</button>
    <a href="{{ route('page.home') }}" class="btn btn-secondary">Opt-Out</a>
</div>
