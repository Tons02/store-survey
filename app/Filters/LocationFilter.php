<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class LocationFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "sync_id",
        "code",
        "name",
        "is_active",
    ];
    protected array $allowedSorts = ["updated_at"];

    protected array $columnSearch = [
        "sync_id",
        "code",
        "name",
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
