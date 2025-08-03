<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ReportTemplateField
 *
 * @property int $id
 * @property int $report_category_id
 * @property string $field_name
 * @property string $field_key
 * @property string $field_type
 * @property array|null $field_options
 * @property bool $is_required
 * @property int $sort_order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ReportCategory $reportCategory
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereReportCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereFieldKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereFieldType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereFieldOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportTemplateField active()
 * @method static \Database\Factories\ReportTemplateFieldFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ReportTemplateField extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_category_id',
        'field_name',
        'field_key',
        'field_type',
        'field_options',
        'is_required',
        'sort_order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'field_options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the report category that owns this field.
     */
    public function reportCategory(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class);
    }

    /**
     * Scope a query to only include active fields.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}