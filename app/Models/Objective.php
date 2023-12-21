<?php

namespace App\Models;

use App\Models\Location;
use App\Filters\ObjectiveFilter;
use App\Filters\DepartmentFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Objective extends Model
{
    use HasFactory, Filterable, softDeletes;
    
    protected $fillable = [
        'id',
        'objective',
        'location_id',
        'is_active',
        'created_at'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        "updated_at", 
        "deleted_at"
    ];

    protected string $default_filters = ObjectiveFilter::class;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'sync_id');
    }

    
}
