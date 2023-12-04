<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Location;
use App\Models\Companies;
use App\Models\Department;
use App\Models\RoleManagement;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_prefix', 
        'id_no',
        'first_name',
        'middle_name', 
        'last_name',
        'sex',
        'username', 
        'password',
        'location_id',
        'department_id', 
        'company_id',
        'role_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "created_at", 
        "updated_at", 
        "deleted_at"
    ];


    /**
     * The attributes that should be cast.
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'role_id' => 'integer'
    ];

    public function role()
    {
        return $this->belongsTo(RoleManagement::class, 'role_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'sync_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'sync_id');
    }

    public function companies()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'sync_id');
    }


   
}
