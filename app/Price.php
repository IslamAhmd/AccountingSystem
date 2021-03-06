<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded = [];

    public function setPriceDateAttribute($value){

    	$this->attributes['price_date'] = date('Y/m/d', strtotime($value));
    } 

    public function products(){

    	return $this->belongsToMany('App\Product');
    }

}
