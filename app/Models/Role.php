<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
class Role extends Model
{
    protected $fillable = ['name', 'slug'];

  
     public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_role',
            'role_id',
            'permission_id'
        );
    }

     public function admins()
    {
        return $this->belongsToMany(
            Admin::class,
            // 'admin_role',
            'role_id',
            'admin_id'
        );
    }

public function roles(): BelongsToMany
{
    return $this->belongsToMany(
        Role::class,
        'admin_role',
        'admin_id',
        'role_id'
    );
}

}