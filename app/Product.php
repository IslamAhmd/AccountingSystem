<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [

    	'brand' => 'array',
    	'category' => 'array',
    	'tag' => 'array',
    	
    ];

    public function prices(){

    	return $this->belongsToMany('App\Price');
    }

    public function taxes(){

    	return $this->belongsToMany('App\Tax');
    }
}
