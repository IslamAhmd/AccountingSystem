<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];

    public function setBalanceDateAttribute($value){
    	
    	$this->attributes['balance_date'] = date('Y/m/d', strtotime($value));
    }
}
