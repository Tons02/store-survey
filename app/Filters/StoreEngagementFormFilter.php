<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class StoreEngagementFormFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "id",
        "name",
        "contact",
        "store_name",
        "leader",
        "objectives",
        "strategies",
        "activities",
        "findings",
        "notes",
        "is_update",
        "is_active",
        "created_at",
    ];
    
    protected array $allowedSorts = ["updated_at"];

    protected array $columnSearch = [
        "id",
        "name",
        "contact",
        "store_name",
        "leader",
        "objectives",
        "strategies",
        "activities",
        "findings",
        "notes",
        "is_update",
        "is_active",
        "created_at",
    ];

    public function from($from)
    {
        $this->builder->whereDate("updated_at", ">=", $from);
    }

    public function to($to)
    {
        $this->builder->whereDate("updated_at", "<=", $to);
    }
}
