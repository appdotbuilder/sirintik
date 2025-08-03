<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ReportCategory;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SirintikSystemTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_dashboard_displays_correctly_for_superadmin(): void
    {
        $user = User::factory()->create(['role' => 'superadmin']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('dashboard')
            ->has('user')
            ->has('stats')
        );
    }

    public function test_dashboard_displays_correctly_for_admin_kecamatan(): void
    {
        $user = User::factory()->create(['role' => 'admin_kecamatan', 'district' => 'Bandung Utara']);
        
        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('dashboard')
            ->has('user')
            ->has('stats')
        );
    }

    public function test_admin_kecamatan_can_create_report(): void
    {
        $user = User::factory()->create(['role' => 'admin_kecamatan', 'district' => 'Bandung Utara']);
        $category = ReportCategory::factory()->create();
        
        $response = $this->actingAs($user)->get('/reports/create');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('reports/create')
            ->has('categories')
        );
    }

    public function test_report_can_be_created_by_admin_kecamatan(): void
    {
        $user = User::factory()->create(['role' => 'admin_kecamatan', 'district' => 'Bandung Utara']);
        $category = ReportCategory::factory()->create();
        
        $reportData = [
            'report_category_id' => $category->id,
            'title' => 'Test Report',
            'description' => 'Test Description',
            'data' => [
                'jenis_tanaman' => 'Padi',
                'luas_lahan' => 10.5,
                'produksi' => 15.2,
            ],
            'report_date' => now()->format('Y-m-d'),
            'status' => 'draft',
        ];
        
        $response = $this->actingAs($user)->post('/reports', $reportData);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('reports', [
            'title' => 'Test Report',
            'user_id' => $user->id,
        ]);
    }

    public function test_reports_index_displays_correctly(): void
    {
        $user = User::factory()->create(['role' => 'admin_kecamatan']);
        $category = ReportCategory::factory()->create();
        $report = Report::factory()->create([
            'user_id' => $user->id,
            'report_category_id' => $category->id,
        ]);
        
        $response = $this->actingAs($user)->get('/reports');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('reports/index')
            ->has('reports.data', 1)
            ->has('categories')
        );
    }

    public function test_welcome_page_displays_sirintik_content(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('welcome')
        );
    }
}