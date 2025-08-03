<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\ReportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
*/
class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Report>
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'report_category_id' => ReportCategory::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'data' => [
                'jenis_tanaman' => $this->faker->randomElement(['Padi', 'Jagung', 'Kedelai']),
                'luas_lahan' => $this->faker->randomFloat(2, 1, 100),
                'produksi' => $this->faker->randomFloat(2, 10, 1000),
            ],
            'status' => $this->faker->randomElement(['draft', 'submitted', 'verified', 'rejected']),
            'verified_by' => null,
            'verified_at' => null,
            'verification_notes' => null,
            'report_date' => $this->faker->date(),
            'district' => $this->faker->randomElement([
                'Bandung Utara', 'Bandung Selatan', 'Cimahi', 'Sumedang', 'Garut'
            ]),
        ];
    }
}