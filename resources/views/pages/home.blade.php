<x-front.layout>
    <div class="d-flex flex-column h-100">
        <x-front.banner image="{{ asset('img/banner-explore.jpg') }}" color="#121628">
            <h2>Clovercraft SMP</h2>
            <p>Explore the world of Clovercraft and build your name into lore!</p>
        </x-front.banner>
        <x-front.banner image="{{ asset('img/banner-community.jpg') }}" color="#988c94">
            <h2>A gaming community for everyone</h2>
            <p>Providing a safe and inclusive community for members of any background.</p>
        </x-front.banner>
        <x-front.banner image="{{ asset('img/banner-join.jpg') }}" color="#206b4b" link="{{ route('auth.login') }}">
            <h2>Become a member</h2>
            <p>Join our discord &amp; get whitelisted today!</p>
        </x-front.banner>
    </div>
</x-front.layout>
