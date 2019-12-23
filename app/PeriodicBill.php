<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodicBill extends Model
{
    public function setFirstBillDateAttribute($value){
    	$this->attributes['first_bill_date'] = date('Y/m/d', strtotime($value));
    }
}
