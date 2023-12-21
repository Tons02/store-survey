<?php

namespace App\Models;

use App\Filters\RoleManagementFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Essa\APIToolKit\Filters\Filterable;

class RoleManagement extends Model
{
    use HasFactory, softDeletes, Filterable;
    protected $fillable = [
        'id',
        'name',
        'access_permission',
        'is_active'
    ];

    protected $hidden = [
        // "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    protected string $default_filters = RoleManagementFilter::class;

    protected $casts = [
        'access_permission' => 'json',
        'is_active' => 'boolean'
    ];
    
}
