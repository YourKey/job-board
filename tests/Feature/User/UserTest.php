<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_has_a_starting_balance()
    {
        $user = User::factory()->create();

        $this->assertIsInt($user->balance);
        $this->assertEquals(config('user.start_balance'), $user->balance);
    }
}
