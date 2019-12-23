<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function setDateAttribute($value){
    	$this->attributes['date'] = date('Y/m/d', strtotime($value));
    }
}
