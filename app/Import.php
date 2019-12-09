<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = ['name', 'import_num', 'starts_at', 'ends_at', 'budget', 'client_id', 'employee_id', 'shipment_num', 'container_data', 'shipment_date', 'arrival_date', 'abstract_name', 'abstract_num', 'shipment_location', 'doc_credit_num', 'gurantee_letter_num', 'employee'];


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

    
}
