<x-front.layout>
    <div class="fluid-container d-flex flex-column h-100 mt-5 p-3">
        <div class="row">
            <div class="col-8">
                <h1>{{ $user->name }}</h1>
                <img src="{{ $user->avatar }}" class="img-fluid" alt="{{ $user->name }} Discord profile picture" />
                <hr>
                <div class="d-flex flex-column w-50">
                    <div class="py-3">
                        @if ($user->whitelisted_at === null)
                            <div class="alert alert-primary" role="alert">
                                <h4 class="alert-heading">You're almost set!</h4>
                                <p>You're registered with our site, but there's a couple more things we'll need to
                                    whitelist you.</p>
                                <ul>
                                @empty($profile->player)
                                    <li>Enter your Minecraft username below to complete verification</li>
                                @endempty
                                @if (!$user->intro_verified)
                                    <li>You need to post an introduction with your name, age, and pronouns in our
                                        #introductions channel. Once you have, click the "Re-check Channel" link
                                        below to verify.</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <table class="table">
                        <tbody>
                            @if (!empty($profile->player))
                                <tr>
                                    <td>Minecraft Account</td>
                                    <td>{{ $profile->player['username'] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Verify Minecraft Account</td>
                                    <td>
                                        <form method="POST" action="{{ route('validation.minecraft') }}">
                                            @if (session('minecraft_id_error'))
                                                <div class="row">
                                                    <p class="text-danger">{{ session('minecraft_id_error') }}</p>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-8">
                                                    {{ csrf_field() }}
                                                    <input type="text" name="minecraft_id" class="form-control"
                                                        placeholder="Minecraft Username" />
                                                </div>
                                                <div class="col-4">
                                                    <button type="submit" class="btn btn-primary">Verify</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>Introduction Verified</td>
                                @if ($user->intro_verified)
                                    <td>True</td>
                                @else
                                    <td>
                                        @if (session('intro_error'))
                                            <div class="row">
                                                <p class="text-danger">{{ session('intro_error') }}</p>
                                            </div>
                                        @endif
                                        <div class="row">
                                            @can('manage', $user)
                                                <a href="{{ route('validation.forceIntro', ['user' => $user]) }}">Force
                                                    Verification</a>
                                            @endcan
                                            <a href="{{ route('validation.intro') }}">Re-check Channel</a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $user->status }}</td>
                            </tr>
                            @if ($user->discord_joined_at !== null)
                                <tr>
                                    <td>Member Since</td>
                                    <td>{{ $user->discord_joined_at->format('M d, Y') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Web Registration on</td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @can('manage', $user)
                <div class="profile-controls">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($user->role->slug != 'admin' && $authuser->role->slug == 'admin')
                                <tr>
                                    <td><a
                                            href="{{ route('admin.members.setRole', ['user' => $user, 'role' => 'admin']) }}">Change
                                            role to Administrator</a></td>
                                </tr>
                            @endif
                            @if ($user->role->slug != 'staff')
                                <tr>
                                    <td><a
                                            href="{{ route('admin.members.setRole', ['user' => $user, 'role' => 'staff']) }}">Change
                                            role to Staff</a></td>
                                </tr>
                            @endif
                            @if ($user->role->slug != 'member')
                                <tr>
                                    <td><a
                                            href="{{ route('admin.members.setRole', ['user' => $user, 'role' => 'member']) }}">Change
                                            role to Member</a></td>
                                </tr>
                            @endif
                            <tr>
                                <td><a href="">Ban User</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endcan
        </div>
    </div>
</x-front.layout>
