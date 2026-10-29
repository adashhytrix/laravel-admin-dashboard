<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'slug'];

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class)
    //         ->withTimestamps();
    // }
    //  public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
      public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'permission_role',
            'permission_id',
            'role_id'
        );
    }
}