<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ReportCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReportTemplateField> $templateFields
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicSummary> $publicSummaries
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportCategory active()
 * @method static \Database\Factories\ReportCategoryFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ReportCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the template fields for this category.
     */
    public function templateFields(): HasMany
    {
        return $this->hasMany(ReportTemplateField::class)->orderBy('sort_order');
    }

    /**
     * Get the reports for this category.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get the public summaries for this category.
     */
    public function publicSummaries(): HasMany
    {
        return $this->hasMany(PublicSummary::class);
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}