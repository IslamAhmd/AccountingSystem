<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = [];

    public function setBillDateAttribute($value){

    	$this->attributes['billdate'] = date('Y/m/d', strtotime($value));
    }


    public function setReleaseDateAttribute($value){

    	$this->attributes['releasedate'] = date('Y/m/d', strtotime($value));
    } 
}
