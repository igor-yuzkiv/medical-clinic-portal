<?php

namespace App\Containers\Appointment\Filters;

use App\Abstractions\Filter\Filter;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class CurrentUserAppointmentsFilter extends Filter
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        $user = auth()->user();
        if ($user->role === UserRoleEnum::DOCTOR) {
            return $query->where('doctor_id', $user->id);
        }else {
            $patient = Patient::where('user_id', $user->id)->firstOrFail();
            return $query->where('patient_id', $patient->id);
        }
    }
}
