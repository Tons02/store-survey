<?php

namespace App\Models;

use App\Models\Objective;
use App\Filters\StrategyFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strategy extends Model
{
    use HasFactory, Filterable, softDeletes;
    
    protected $fillable = [
        'id',
        'objective_id',
        'strategy',
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

    protected string $default_filters = StrategyFilter::class;

    public function objective()
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }
}
