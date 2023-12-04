<?php

namespace App\Models;

use App\Models\Companies;
use App\Models\DepartmentLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'sync_id',
        'code',
        'name',
        'company_sync_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'company_sync_id' => 'integer'
    ];

    protected $hidden = [
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_sync_id', 'sync_id');
    }

    

}
