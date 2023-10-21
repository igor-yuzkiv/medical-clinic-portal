<?php

namespace App\Filters;

use App\Abstractions\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

class UpcomingAppointmentsFilter extends Filter
{
    public function apply(Builder $query): Builder
    {
        return $query
            ->whereDate("date_time", '>=', today());
    }
}
