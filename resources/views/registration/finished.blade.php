<div class="container mt-5">
    <h1>Congrats, {{ $authuser->name }}!</h1>
    <h2>You are now a fully registered member of Clovercraft.</h2>
    <p>Our auto-whitelisting feature isn't functioning as intended right now. To finish getting whitelisted, please post
        your MC username in the #bug-reports channel on Discord. Please note, you will need to have posted an
        introduction to be whitelisted.</p>
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
