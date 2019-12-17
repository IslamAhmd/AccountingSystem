<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supplier;

class Purchase extends Model
{

	protected $guarded = [];


    public function setDateAttribute($value){

    	$this->attributes['date'] = date('Y/m/d', strtotime($value));
    } 


}
