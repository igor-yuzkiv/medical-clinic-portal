<?php

namespace App\Containers\Patient\Models;

use App\Abstractions\Filter\HasFilter;
use App\Containers\User\Enums\GenderEnum;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class Patient extends Model
{
    use SoftDeletes, HasFilter;

    /**
     * @var string
     */
    protected $table = "patients";

    /**
     * @var string[]
     */
    protected $fillable = [
        "name",
        "phone",
        "email",
        "gender",
        "source_id",
        "user_id",
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'gender' => GenderEnum::class,
    ];

    /**
     * @var array
     */
    protected array $filters = [];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'patient_id', 'doctor_id');
    }
}
