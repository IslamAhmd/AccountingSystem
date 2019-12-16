<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Repo extends Model
{
    protected $guarded = [];


    // protected $casts = [
    // 	'show_emp_name' => 'array'
    // ];


    // public function setShowEmpNameAttribute($value){
    // 	$this->attributes['show_emp_name'] = json_encode($value);
    // }

}
