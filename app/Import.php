<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Client;

class Import extends Model
{
    protected $guarded = ['client_name'];

    protected $hidden = ['pivot', 'employees'];

    protected $casts = [

        'tag' => 'array',
        'abstract_name' => 'array',
        'shipment_location' => 'array'
    ];

    public function setStartsAtAttribute($value){

    	$this->attributes['starts_at'] = date('Y/m/d', strtotime($value));

    }

    public function setEndsAtAttribute($value){

    	$this->attributes['ends_at'] = date('Y/m/d', strtotime($value));

    }

    public function setShipmentDateAttribute($value){

    	$this->attributes['shipment_date'] = date('Y/m/d', strtotime($value));

    }

    public function setArrivalDateAttribute($value){

    	$this->attributes['arrival_date'] = date('Y/m/d', strtotime($value));

    }

    public function employees(){

        return $this->belongsToMany('App\Employee');

    }
    
}
