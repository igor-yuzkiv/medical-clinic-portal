<?php

namespace App\Containers\Appointment\Models;

use App\Abstractions\Filter\HasFilter;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Appointment extends Model
{
    use SoftDeletes, HasFilter;

    /**
     * @var string
     */
    protected $table = 'appointments';

    /**
     * @var string[]
     */
    protected $fillable = [
        "doctor_id",
        "patient_id",
        "date_time",
        "service_name",
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        "date_time" => "datetime",
    ];

    /**
     * @return HasOne
     */
    public function doctor(): HasOne
    {
        return $this->hasOne(User::class, "id", "doctor_id");
    }

    /**
     * @return HasOne
     */
    public function patient(): HasOne
    {
        return $this->hasOne(User::class, "id", "patient_id");
    }
}
