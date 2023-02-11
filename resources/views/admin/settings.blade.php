<x-front.layout>
    <div class="fluid-container d-flex flex-column h-100 mt-5 p-3 mb-2">
        <form method="POST" action="{{ route('admin.updateSettings') }}">
            <div class="mb-3">
                <label for="whitelist-enabled" class="form-label">Enable Whitelist Relay</label>
                <select name="whitelist-enabled" id="whitelist-enabled" class="form-select">
                    <option value="1" {{ $whitelistEnabled ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ $whitelistEnabled ? '' : 'selected' }}>No</option>
                </select>
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</x-front.layout>
