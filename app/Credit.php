<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    public function setCreditDateAttribute($value){
    	$this->attributes['credit_date'] = date('Y/m/d', strtotime($value));
    }

    public function setReleaseDateAttribute($value){
    	$this->attributes['release_date'] = date('Y/m/d', strtotime($value));
    }

}
