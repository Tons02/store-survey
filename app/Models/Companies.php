<?php

namespace App\Models;

use App\Filters\CompaniesFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\softDeletes;

class Companies extends Model
{
    use HasFactory, Filterable, softDeletes;
    protected $fillable = [
        'sync_id',
        'code',
        'name',
        'is_active'
    ];

    protected $hidden = [
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    protected string $default_filters = CompaniesFilter::class;

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
