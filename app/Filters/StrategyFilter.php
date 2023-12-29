<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class StrategyFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "id",
        "objective_id",
        "strategy",
        "created_at", 
    ];
    
    protected array $allowedSorts = ["updated_at"];

    protected array $relationSearch = [
        'objectives' => ['objective']
    ];

    protected array $columnSearch = [
        "id",
        "objective_id",
        "strategy",
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
