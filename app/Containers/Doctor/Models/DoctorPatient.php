<?php

namespace App\Containers\Doctor\Models;

use App\Containers\Patient\Models\Patient;
use App\Containers\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 */
class DoctorPatient extends Model
{
    /**
     * @var string
     */
    protected $table = "doctor_patient";

    /**
     * @var string[]
     */
    protected $fillable = [
        "doctor_id",
        "patient_id",
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
}
