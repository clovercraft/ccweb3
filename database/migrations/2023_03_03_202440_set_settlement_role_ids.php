<?php

use App\Models\Settlement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role_ids = [
            'silanah'   => '1079436606244671649',
            'foxfen'    => '1079436694719307796',
            'serenity'  => '1079436781457522779',
            'snagbledes'    => '1079616401226092554'
        ];

        $settlements = Settlement::all();

        foreach ($settlements as $settlement) {
            if (array_key_exists($settlement->slug, $role_ids)) {
                $role_id = $role_ids[$settlement->slug];
                $settlement->discord_role_id = $role_id;
                $settlement->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
