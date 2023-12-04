<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class RoleManagement extends Model
{
    use HasFactory, softDeletes;
    protected $fillable = [
        'id',
        'name',
        'access_permission',
        'is_active'
    ];

    protected $hidden = [
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    protected $casts = [
        'access_permission' => 'json',
        'is_active' => 'boolean'
    ];
    
}
