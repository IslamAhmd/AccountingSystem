<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['name', 'admin'];

    
    public function permissions() {
        return $this->belongsToMany(Permission::class,'permissions_roles');
    }
}
