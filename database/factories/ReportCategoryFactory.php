<?php

namespace Database\Factories;

use App\Models\ReportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportCategory>
*/
class ReportCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\ReportCategory>
     */
    protected $model = ReportCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Tanaman Pangan',
            'Hortikultura', 
            'Perkebunan',
            'Peternakan'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}