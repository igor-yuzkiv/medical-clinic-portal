<?php

namespace App\Filters;

use App\Abstractions\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchUserFilter extends Filter
{
    public function apply(Builder $query): Builder
    {
        $keyword = $this->parameterBag->get(0);
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
