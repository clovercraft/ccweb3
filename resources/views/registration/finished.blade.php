<div class="container mt-5">
    <h1>Congrats, {{ $authuser->name }}!</h1>
    <h2>You are now registered on our whitelist</h2>
    @if ($whitelistEnabled)
        <p>You should now be able to log in to the Clovercraft SMP, which you can find at mc.clovercraft.gg. If you
            can't log in, please contact our support staff by opening a ticket on our Discord server.</p>
    @else
        <p>You're all set, and when the new season launches you'll automatically get added to our whitelist. Stay tuned
            for our launch update soon!</p>
    @endif
    <h2>What's Next?</h2>
    <p>You're all set to log on to the server, which you can add to your client at the IP mc.clovercraft.gg. If you'd
        like, here are a few other things to check out!</p>
    <ul>
        <li>Check out your <a href="{{ route('page.profile', ['user' => $authuser->id]) }}">Member Profile</a> here on
            our website</li>
        <li>Read our <a href="https://wiki.clovercraft.gg/player-guide" target="_blank">Player Guide</a> on the
            Clovercraft Wiki</li>
        <li>Install our preferred launcher, <a href="https://multimc.org" target="_blank">MultiMC</a>, so you can manage
            multiple versions of the game</li>
        <li>Download one of our <a href="https://modrinth.com/modpacks?q=clovercraft" target="_blank">Official
                Modpacks</a> to enhance your game</li>
    </ul>
</div>
