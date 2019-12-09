<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientDate extends Model
{
    protected $fillable = ['client_id', 'date', 'duration', 'time', 'action'];


    public function setDateAttribute($value){

    	$this->attributes['date'] = date('Y/m/d', strtotime($value));
    } 

    // date("H:i", strtotime($Hour1));

    public function setDurationAttribute($value){

    	$this->attributes['duration'] = date("H:i", strtotime($value));
    }  

    public function setTimeAttribute($value){

    	$this->attributes['time'] = date("H:i", strtotime($value));
    }  

}
