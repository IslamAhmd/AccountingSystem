<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $guarded = [];

    protected $casts = [
        'name' => 'array',
        'viewname' => 'array'
    ];


    public function roles() {
        return $this->belongsToMany(Role::class,'permissions_roles');
    }
}
