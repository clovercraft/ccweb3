<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class SetRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:setrole {user_id} {role_slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a users role';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user_id'));
        $role = Role::where('slug', $this->argument('role_slug'))->first();

        if (empty($user) || empty($role)) {
            $this->error("User or Role could not be found.");
            return Command::FAILURE;
        }

        $user->role_id = $role->id;
        $user->save();

        $this->info("User $user->id now has role: $role->displayname");

        return Command::SUCCESS;
    }
}
