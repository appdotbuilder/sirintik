<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $user_id
 * @property int $report_category_id
 * @property string $title
 * @property string|null $description
 * @property array $data
 * @property string $status
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property string|null $verification_notes
 * @property string $report_date
 * @property string $district
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ReportCategory $reportCategory
 * @property-read \App\Models\User|null $verifier
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReportCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereVerifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereVerificationNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report draft()
 * @method static \Illuminate\Database\Eloquent\Builder|Report submitted()
 * @method static \Illuminate\Database\Eloquent\Builder|Report verified()
 * @method static \Illuminate\Database\Eloquent\Builder|Report rejected()
 * @method static \Database\Factories\ReportFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'report_category_id',
        'title',
        'description',
        'data',
        'status',
        'verified_by',
        'verified_at',
        'verification_notes',
        'report_date',
        'district',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'verified_at' => 'datetime',
        'report_date' => 'date',
    ];

    /**
     * Get the user who created this report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the report category.
     */
    public function reportCategory(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class);
    }

    /**
     * Get the user who verified this report.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope a query to only include draft reports.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include submitted reports.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope a query to only include verified reports.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope a query to only include rejected reports.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}