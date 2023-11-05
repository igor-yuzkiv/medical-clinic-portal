<?php

namespace App\Containers\Appointment\Models;

use App\Abstractions\Filter\HasFilter;
use App\Containers\Appointment\Enums\ServiceType;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\Models\User;
use Database\Factories\AppointmentFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class Appointment extends Model
{
    use HasFactory, SoftDeletes, HasFilter;

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
        "service_type",
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        "date_time"    => "datetime",
        "service_type" => ServiceType::class,
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
        return $this->hasOne(Patient::class, "id", "patient_id");
    }

    public static function newFactory(): Factory
    {
        return AppointmentFactory::new();
    }
}
