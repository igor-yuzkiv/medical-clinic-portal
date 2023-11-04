<?php

namespace App\Containers\Patient\Filters;

use App\Abstractions\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class DoctorPatientsFilter extends Filter
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        return $query->whereHas("doctors", function (Builder $query) {
            $query->where("doctor_id", $this->parameterBag->get(0));
        });
    }
}
