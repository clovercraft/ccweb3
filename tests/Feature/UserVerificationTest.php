<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserVerificationTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    private User $user;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_valid_names_verify()
    {
        // test good username
        $response = $this
            ->actingAs($this->user)
            ->post('/validate/minecraft', [
                'minecraft_id' => 'zenfrii'
            ]);
        $response->assertStatus(302);

        $this->user->refresh();
        $this->assertNotEmpty($this->user->mc_verified_at);
    }

    public function test_invalid_names_fail()
    {
        // test bad username
        $response = $this
            ->actingAs($this->user)
            ->post('/validate/minecraft', [
                'minecraft_id' => 'thiscantpossiblybeausername'
            ]);
        $response->assertStatus(302);
        $response->assertSessionHas('minecraft_id_error');

        $this->user->refresh();
        $this->assertEmpty($this->user->mc_verified_at);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
}
