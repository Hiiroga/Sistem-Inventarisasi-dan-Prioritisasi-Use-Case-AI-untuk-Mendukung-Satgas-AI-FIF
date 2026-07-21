<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalRoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_admin_pages(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('dashboard.usecase'))
            ->assertForbidden();
    }

    public function test_admin_uses_the_same_web_guard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('dashboard.usecase'))
            ->assertOk();
    }

    public function test_user_cannot_choose_admin_login_mode(): void
    {
        $user = User::factory()->create([
            'email' => 'user@student.telkomuniversity.ac.id',
            'password' => 'password',
            'role' => 'user',
        ]);

        $this->post(route('portal.login.submit'), [
            'login_as' => 'admin',
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
