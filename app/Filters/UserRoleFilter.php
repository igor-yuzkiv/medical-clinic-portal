<?php

namespace App\Filters;

use App\Abstractions\Filter\Filter;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class UserRoleFilter extends Filter
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        $role = UserRoleEnum::tryFrom($this->parameterBag->get("role"));
        if (!$role) {
            return $query;
        }
        return $query->where("role", $role->value);
    }
}
