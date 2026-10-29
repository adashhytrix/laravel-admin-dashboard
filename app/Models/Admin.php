<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
        use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
         'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

public function roles()
{
    return $this->belongsToMany(
        Role::class,
        'admin_role',
        'admin_id',
        'role_id',
        
    );
}

public function hasPermission(string $permission): bool
{
   
    return $this->roles()
        ->whereHas('permissions', function ($query) use ($permission) {
            $query->where('slug', $permission);
        })
        ->exists();
}

}