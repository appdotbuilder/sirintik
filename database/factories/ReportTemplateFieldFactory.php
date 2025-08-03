<?php

namespace Database\Factories;

use App\Models\ReportTemplateField;
use App\Models\ReportCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportTemplateField>
*/
class ReportTemplateFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\ReportTemplateField>
     */
    protected $model = ReportTemplateField::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fieldName = $this->faker->randomElement([
            'Jenis Tanaman',
            'Luas Lahan',
            'Produksi',
            'Harga Jual',
            'Kendala Utama'
        ]);

        return [
            'report_category_id' => ReportCategory::factory(),
            'field_name' => $fieldName,
            'field_key' => strtolower(str_replace(' ', '_', $fieldName)),
            'field_type' => $this->faker->randomElement(['text', 'number', 'textarea', 'select']),
            'field_options' => null,
            'is_required' => $this->faker->boolean(70),
            'sort_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}