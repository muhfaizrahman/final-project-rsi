<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();
    // }
    /**
     * A basic unit test example.
    */
    public function test_access_apply_page_as_guest(): void
    {
        $this->actingAsGuest();
        $response = $this->get('/home');
        $response->assertStatus(302);
    }

    public function test_access_apply_page_with_wrong_role(): void
    {
        $user = User::factory()->create([
            'role' => 'perusahaan',
        ]);

        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertForbidden();
    }

    public function test_access_apply_page_with_correct_role(): void
    {
        $user = User::factory()->create([
            'role' => 'pelamar',
        ]);

        $this->actingAs($user);

        $response = $this->get('/home');
        $response->assertStatus(200);
    }
}
