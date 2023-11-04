<?php

namespace App\Containers\User\Models;

use App\Abstractions\Filter\HasFilter;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\Enums\GenderEnum;
use App\Containers\User\Enums\UserRoleEnum;
use App\Containers\User\Filters\UserRoleFilter;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'email',
        'phone',
        'password',
        "role",
        "is_active",
        "last_activity_at",
        "source_id",
        "gender",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity_at'  => 'datetime',
        'is_active'         => 'bool',
        'password'          => 'hashed',
        'role'              => UserRoleEnum::class,
        'gender'            => GenderEnum::class,
    ];

    /**
     * @var array|string[]
     */
    protected array $filters = [
        'role'   => UserRoleFilter::class,
    ];

    /**
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'login';
    }

    /**
     * @return BelongsToMany
     */
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'doctor_patient', 'doctor_id', 'patient_id');
    }

    /**
     * @return Factory
     */
    public static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
