<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillReports extends Model
{
    protected $guarded = [];

    public function setFromAttribute($value){
    	$this->attributes['from'] = date('Y/m/d', strtotime($value));
    }


    public function setToAttribute($value){
    	$this->attributes['to'] = date('Y/m/d', strtotime($value));
    }
}
