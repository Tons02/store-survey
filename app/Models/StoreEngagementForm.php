<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\StoreEngagementFormFilter;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Essa\APIToolKit\Filters\Filterable;

class StoreEngagementForm extends Model
{
    use HasFactory, softDeletes, Filterable;

    protected $fillable = [
        'visit_number',
        'name',
        'contact',
        'store_name',
        'leader',
        'date',
        'objectives',
        'strategies',
        'activities',
        'findings',
        'notes',
        'e_signature',
        'is_update',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_update' => 'boolean',
        'objectives' => 'json',
        'strategies' => 'json',
        'activities' => 'json',
        'notes' => 'json'
    ];

    protected $hidden = [
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    protected string $default_filters = StoreEngagementFormFilter::class;
}
