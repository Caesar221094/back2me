<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Report;

class PetugasVerifyTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_can_update_status()
    {
        $this->seed(\Database\Seeders\Back2MeSeeder::class);

        $petugas = User::where('role','petugas')->first();
        $report = Report::first();

        $this->actingAs($petugas)
            ->post(route('back2me.reports.verify', $report), ['status' => 'selesai'])
            ->assertRedirect();

        $this->assertDatabaseHas('reports', ['id' => $report->id, 'status' => 'selesai']);
    }
}
