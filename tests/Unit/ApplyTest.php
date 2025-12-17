<?php

namespace Tests\Unit;

use App\Models\User;
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
}
