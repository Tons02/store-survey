<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class RoleManagementFilter extends QueryFilters
{
    protected array $allowedFilters = [
        "name",
        "access_permission",
    ];
    protected array $allowedSorts = ["updated_at"];

    protected array $columnSearch = [
        "name",
        "access_permission",
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
