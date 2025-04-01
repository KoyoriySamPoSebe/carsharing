<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email'    => 'test@email.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function testLoginPage(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testUserCanAuthenticate(): void
    {
        $response = $this->post(
            '/login',
            [
                'email'    => 'test@email.com',
                'password' => 'password',
            ],
        );

        $this->assertAuthenticated();
        $response->assertRedirect(route('vehicles.index', absolute: false));
    }

    public function testUserCanNotAuthenticate(): void
    {
        $this->post(
            '/login',
            [
                'email'    => 'test@email.com',
                'password' => 'wrong-password',
            ],
        );

        $this->assertGuest();
    }

    public function testUserCanLogout(): void
    {
        $response = $this->actingAs($this->user)->post('/logout');
        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
