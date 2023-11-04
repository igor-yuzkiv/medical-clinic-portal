<?php

namespace App\Containers\User\Filters;

use App\Abstractions\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
class SearchUserFilter extends Filter
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        $keyword = $this->parameterBag->get('keyword');
        if (!$keyword) {
            return $query;
        }

        return $query
            ->where(function (Builder $query) use ($keyword) {
                $query->where("name", "like", "%{$keyword}%")
                    ->orWhere("phone", "like", "%{$keyword}%");
            });
    }
}
