<x-front.layout>
    <div class="fluid-container d-flex flex-column h-100 mt-5 p-3">
        <div class="row">
            <div class="col-8">
                <h1>{{ $user->name }}</h1>
                <img src="{{ $user->avatar }}" class="img-fluid" alt="{{ $user->name }} Discord profile picture" />
                <hr>
                <div class="d-flex flex-column w-50">
                    <div class="py-3">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Minecraft Account</td>
                                    <td>{{ $player }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $user->status }}</td>
                                </tr>
                                <tr>
                                    <td>Member Since</td>
                                    <td>{{ $member->get('joined_at') }}</td>
                                </tr>
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
