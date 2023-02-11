<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('discord_id')->unique();
            $table->string('minecraft_id')->unique();
            $table->string('avatar')->nullable();
            $table->enum('status', ['new', 'active', 'inactive', 'banned'])->default('new');
            $table->dateTime('whitelisted_at')->nullable();
            $table->dateTime('banned_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
