<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PublicSummary
 *
 * @property int $id
 * @property int $report_category_id
 * @property int $created_by
 * @property string $title
 * @property string $summary_content
 * @property array|null $statistics
 * @property string $period_start
 * @property string $period_end
 * @property string|null $district
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ReportCategory $reportCategory
 * @property-read \App\Models\User $creator
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereReportCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereSummaryContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereStatistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PublicSummary published()
 * @method static \Database\Factories\PublicSummaryFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class PublicSummary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_category_id',
        'created_by',
        'title',
        'summary_content',
        'statistics',
        'period_start',
        'period_end',
        'district',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'statistics' => 'array',
        'period_start' => 'date',
        'period_end' => 'date',
        'is_published' => 'boolean',
    ];

    /**
     * Get the report category.
     */
    public function reportCategory(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class);
    }

    /**
     * Get the user who created this summary.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include published summaries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}