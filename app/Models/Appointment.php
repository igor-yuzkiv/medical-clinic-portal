<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 */
class Appointment extends Model
{
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
    ];

    /**
     * @return HasOne
     */
    public function doctor(): HasOne
    {
        return $this->hasOne(User::class, "id", "doctor_id");
    }
}
