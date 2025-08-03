<?php

namespace Database\Factories;

use App\Models\PublicSummary;
use App\Models\User;
use App\Models\ReportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicSummary>
*/
class PublicSummaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\PublicSummary>
     */
    protected $model = PublicSummary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_category_id' => ReportCategory::factory(),
            'created_by' => User::factory(),
            'title' => $this->faker->sentence(),
            'summary_content' => $this->faker->paragraphs(3, true),
            'statistics' => [
                'total_reports' => $this->faker->numberBetween(10, 100),
                'total_area' => $this->faker->randomFloat(2, 100, 10000),
                'total_production' => $this->faker->randomFloat(2, 500, 50000),
            ],
            'period_start' => $this->faker->date(),
            'period_end' => $this->faker->date(),
            'district' => $this->faker->randomElement([
                'Bandung Utara', 'Bandung Selatan', 'Cimahi', null
            ]),
            'is_published' => $this->faker->boolean(80),
        ];
    }
}