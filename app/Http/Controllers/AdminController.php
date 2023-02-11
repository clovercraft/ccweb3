<?php

namespace App\Http\Controllers;

use App\Events\ImportWhitelist;
use App\Models\Generic\FilterButtonData;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function members()
    {
        $users = User::all();

        $statusFilters = new FilterButtonData('member-filter-status');
        $statusFilters->setLabel("Filter by Status")->setOptions([
            User::STATUS_NEW        => 'New',
            User::STATUS_ACTIVE     => 'Active',
            User::STATUS_INACTIVE   => 'Inactive',
            User::STATUS_BANNED     => 'Banned',
        ]);

        $roleFilters = new FilterButtonData('member-filter-role');
        $roleFilters->setLabel("Filter by Role")->optionsFromObjects(Role::all(), 'slug', 'displayname');

        return $this->render('admin.members', [
            'members'   => $users,
            'roles'     => $roleFilters,
            'statuses'  => $statusFilters
        ]);
    }

    public function settings()
    {
        return $this->render('admin.settings', [
            'whitelistEnabled'  => $this->isWhitelistEnabled()
        ]);
    }

    public function updateSettings(Request $request)
    {
        $whitelistEnabled = $request->input('whitelist');
        $setting = Setting::where('key', 'whitelist-relay-enabled')->first();
        if ($whitelistEnabled === "1") {
            $setting->value = 'true';
            $setting->save();
            ImportWhitelist::dispatch($this->getWhitelistedPlayers());
        } else {
            $setting->value = 'false';
            $setting->save();
        }
        return redirect()->route('admin.settings');
    }

    private function getWhitelistedPlayers(): array
    {
        $mcids = [];
        $users = User::where('status', 'active')->whereNotNull('whitelisted_at')->get();
        foreach ($users as $user) {
            $mcids[] = $user->minecraft_id;
        }
        return $mcids;
    }
}
