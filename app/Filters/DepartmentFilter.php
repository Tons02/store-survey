<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class DepartmentFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "sync_id",
        "code",
        "name",
        "company_sync_id",
        "is_active",
    ];
    protected array $allowedSorts = ["updated_at"];

    protected array $columnSearch = [
        "sync_id",
        "code",
        "name",
        "company_sync_id",
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
