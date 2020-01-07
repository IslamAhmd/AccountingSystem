<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Supplier extends Model
{
    protected $guarded = [];

    public function setOpeningBalanceDateAttribute($value){
    	
    	$this->attributes['opening_balance_date'] = date('Y/m/d', strtotime($value));
    }

    protected $casts = [

    	'tag' => 'array'

    ];

}
