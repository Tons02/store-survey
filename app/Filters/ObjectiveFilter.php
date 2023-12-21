<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class ObjectiveFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "id",
        "objective",
        "location_id",
        "created_at", 
    ];
    protected array $allowedSorts = ["updated_at"];

    protected array $relationSearch = [
        'location' => ['name']
    ];

    protected array $columnSearch = [
        "id",
        "objective",
        "location_id",
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
