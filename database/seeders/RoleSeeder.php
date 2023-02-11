<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create([
            'slug' => 'member',
            'displayname' => 'Member'
        ]);

        Role::factory()->create([
            'slug' => 'staff',
            'displayname' => 'Staff'
        ]);

        Role::factory()->create([
            'slug' => 'admin',
            'displayname' => 'Administrator'
        ]);
    }
}
