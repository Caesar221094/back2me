<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RoleProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_superadmin_can_access_admin_routes()
    {
        $this->seed(\Database\Seeders\Back2MeSeeder::class);

        $user = User::where('role','user')->first();

        $this->actingAs($user)
            ->get(route('back2me.admin.users.index'))
            ->assertStatus(403);
    }
}
