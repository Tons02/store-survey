<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
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

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
