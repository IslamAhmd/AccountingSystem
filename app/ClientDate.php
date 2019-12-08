<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ClientDate extends Model
{
    protected $fillable = ['client_id', 'date', 'duration', 'time', 'action'];


    public function setDateAttribute($value){

    	$this->attributes['date'] = date('Y/m/d', strtotime($value));
    }    

}
