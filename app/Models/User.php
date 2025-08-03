<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $district
 * @property string|null $bidang
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $verifiedReports
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PublicSummary> $publicSummaries
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'district',
        'bidang',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the reports created by this user.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get the reports verified by this user.
     */
    public function verifiedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'verified_by');
    }

    /**
     * Get the public summaries created by this user.
     */
    public function publicSummaries(): HasMany
    {
        return $this->hasMany(PublicSummary::class, 'created_by');
    }

    /**
     * Check if user is superadmin.
     */
    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Check if user is admin bidang.
     */
    public function isAdminBidang(): bool
    {
        return $this->role === 'admin_bidang';
    }

    /**
     * Check if user is admin kecamatan.
     */
    public function isAdminKecamatan(): bool
    {
        return $this->role === 'admin_kecamatan';
    }
}