<!-- #Component front/navigation -->
<aside id="site-navigation" class="d-flex flex-column justify-content-between h-100">
    <div id="brand" class="d-flex flex-column w-100 h-auto">
        <a href="{{ route('page.home') }}">
            <img alt="Clovercraft logo" src="{{ asset('img/logo-inverse.png') }}" />
        </a>
        <h1 class="site-title">Clovercraft</h1>
        <span class="tag-line">An open gaming community</span>
    </div>
    <footer class="d-flex flex-column justify-content-between">
        <x-front.member-nav />
        <nav id="site" role="navigation" class="d-flex flex-column justify-content-start">
            <x-common.nav-link url="https://wiki.clovercraft.gg" target="_blank">Clovercraft Wiki</x-common.nav-link>
            <x-common.nav-link url="https://www.patreon.com/clovercraft" target="_blank">Donate</x-common.nav-link>
            @auth
                <div id="login-links" class="d-flex flex-row justify-content-start">
                    <x-common.nav-link url="{{ route('auth.logout') }}">Log Out</x-common.nav-link>
                </div>
            @else
                <div id="login-links" class="d-flex flex-row justify-content-start">
                    <x-common.nav-link url="{{ route('auth.login') }}">Login</x-common.nav-link>
                    <x-common.nav-link url="{{ route('auth.login') }}" class="slashbefore">Join</x-common.nav-link>
                </div>
            @endauth
        </nav>
        <nav id="social" role="complementary" class="d-flex flex-row justify-content-end">
            <x-common.nav-link url="https://discord.gg/clovercraft" target="_blank" icon="fa-brands fa-discord"
                srtext="Discord" />
            <x-common.nav-link url="https://twitter.com/clovercraftmc" target="_blank" icon="fa-brands fa-twitter"
                srtext="Twitter" />
            <x-common.nav-link url="https://patreon.com/clovercraft" target="_blank" icon="fa-brands fa-patreon"
                srtext="Patreon" />
        </nav>
    </footer>

</aside>
<!-- #End front/navigation -->
