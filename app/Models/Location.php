<?php

namespace App\Models;

use App\Models\Department;
use App\Filters\LocationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;

class Location extends Model
{
    use HasFactory, Filterable, softDeletes;
    protected $fillable = [
        'sync_id',
        'code',
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    protected string $default_filters = LocationFilter::class;

    public function department()
    {
        return $this->belongsToMany(
            Department::class,
            "department_location",
            "location_id",
            "department_id",
            "sync_id",
            "sync_id"
        );
    }
}
