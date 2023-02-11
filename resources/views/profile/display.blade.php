<div class="d-flex flex-column mw-50">
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
                    <td>{{ $user->created_at->format('M/d/Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
