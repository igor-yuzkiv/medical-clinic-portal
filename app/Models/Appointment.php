<?php

namespace App\Models;

use App\Abstractions\Filter\HasFilter;
use App\Filters\UpcomingAppointmentsFilter;
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
     * @var array|string[]
     */
    protected array $filters = [
        'upcoming' => UpcomingAppointmentsFilter::class,
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
