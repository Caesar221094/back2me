<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ReportCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_report()
    {
        $this->seed(\Database\Seeders\Back2MeSeeder::class);

        $user = User::where('role','user')->first();

        $this->actingAs($user)
            ->post(route('back2me.reports.store'), [
                'judul' => 'Dompet hilang',
                'deskripsi' => 'Dompet kulit',
            ])
            ->assertRedirect(route('back2me.reports.index'));

        $this->assertDatabaseHas('reports', ['judul' => 'Dompet hilang']);
    }
}
