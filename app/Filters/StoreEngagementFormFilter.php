<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class StoreEngagementFormFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "visit_number",
        "name",
        "contact",
        "store_name",
        "leader",
        "date",
        "objectives",
        "strategies",
        "activities",
        "findings",
        "notes",
        "is_update",
        "is_active",
    ];
    
    protected array $allowedSorts = ["updated_at"];

    protected array $columnSearch = [
        "visit_number",
        "name",
        "contact",
        "store_name",
        "leader",
        "date",
        "objectives",
        "strategies",
        "activities",
        "findings",
        "notes",
        "is_update",
        "is_active",
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
