<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\PenilaianPrioritas;
use App\Models\UseCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UseCaseWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_edit_own_idea(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        $useCase = $this->createUseCase($kategori, $user);

        $response = $this->actingAs($user)->put(route('user.update', $useCase), [
            'nama_use_case' => 'Asisten Akademik Baru',
            'deskripsi' => 'Deskripsi yang sudah diperbarui.',
            'unit_terkait' => 'Fakultas Informatika',
            'kategori_id' => $kategori->id,
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertDatabaseHas('use_cases', [
            'id' => $useCase->id,
            'nama_use_case' => 'Asisten Akademik Baru',
        ]);
    }

    public function test_user_cannot_edit_another_users_idea(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        $useCase = $this->createUseCase($kategori, $owner);

        $this->actingAs($otherUser)
            ->get(route('user.edit', $useCase))
            ->assertForbidden();
    }

    public function test_processed_idea_cannot_be_edited_by_user(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        $useCase = $this->createUseCase($kategori, $user, 'Direncanakan');

        $this->actingAs($user)
            ->get(route('user.edit', $useCase))
            ->assertForbidden();
    }

    public function test_priority_score_includes_infrastructure_readiness(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        $useCase = $this->createUseCase($kategori, $user);

        $assessment = PenilaianPrioritas::create([
            'use_case_id' => $useCase->id,
            'dampak' => 3,
            'kelayakan' => 3,
            'ketersediaan_data' => 3,
            'kesiapan_sdm' => 3,
            'kesiapan_infrastruktur' => 5,
            'urgensi' => 3,
            'risiko_etika_skor' => 3,
            'kompleksitas_teknis' => 3,
        ]);

        $this->assertSame(14, $assessment->skor_prioritas);
        $this->assertSame('Tinggi', $assessment->level_prioritas);
    }

    public function test_admin_can_search_by_proposer_and_technology(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        UseCase::create([
            'kode' => 'UC001',
            'nama_use_case' => 'Asisten Akademik',
            'deskripsi' => 'Membantu layanan akademik.',
            'pengusul' => 'Budi Santoso',
            'unit_terkait' => 'Fakultas Informatika',
            'kategori_id' => $kategori->id,
            'teknologi_ai' => 'Natural Language Processing',
            'status' => 'Ide',
        ]);

        $this->actingAs($admin)
            ->get(route('use-cases.index', ['search' => 'Budi']))
            ->assertOk()
            ->assertSee('Asisten Akademik');

        $this->actingAs($admin)
            ->get(route('use-cases.index', ['search' => 'Natural Language']))
            ->assertOk()
            ->assertSee('Asisten Akademik');
    }

    public function test_status_change_is_recorded_with_actor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kategori = Kategori::create(['nama_kategori' => 'Akademik']);
        $useCase = $this->createUseCase($kategori, $admin);

        $this->actingAs($admin)->put(route('use-cases.update', $useCase), [
            'nama_use_case' => $useCase->nama_use_case,
            'deskripsi' => $useCase->deskripsi,
            'pengusul' => $useCase->pengusul,
            'unit_terkait' => $useCase->unit_terkait,
            'kategori_id' => $kategori->id,
            'status' => 'Direncanakan',
            'catatan_status' => 'Data dan sponsor sudah dikonfirmasi.',
        ])->assertRedirect(route('use-cases.index'));

        $this->assertDatabaseHas('use_case_status_histories', [
            'use_case_id' => $useCase->id,
            'changed_by' => $admin->id,
            'status_sebelumnya' => 'Ide',
            'status_baru' => 'Direncanakan',
            'catatan' => 'Data dan sponsor sudah dikonfirmasi.',
        ]);
    }

    private function createUseCase(
        Kategori $kategori,
        User $user,
        string $status = 'Ide',
    ): UseCase {
        return UseCase::create([
            'user_id' => $user->id,
            'kode' => 'UC'.str_pad((string) (UseCase::count() + 1), 3, '0', STR_PAD_LEFT),
            'nama_use_case' => 'Asisten Akademik',
            'deskripsi' => 'Membantu layanan akademik.',
            'pengusul' => $user->name,
            'unit_terkait' => 'Fakultas Informatika',
            'kategori_id' => $kategori->id,
            'status' => $status,
        ]);
    }
}
