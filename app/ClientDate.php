<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;
use Carbon\Carbon;

class ClientDate extends Model
{
    protected $guarded = [];


    public function setDateAttribute($value){

    	$this->attributes['date'] = date('Y/m/d', strtotime($value));
    } 


    public function setDurationAttribute($value){

    	$this->attributes['duration'] = date("H:i", strtotime($value));
    }  

    public function setTimeAttribute($value){

    	$this->attributes['time'] = date("H:i", strtotime($value));
    }  

    public function getClientNameAttribute($value){

        return Client::where('id', $this->client_id)->first()->trade_name;
    }

    public function setRepeatedDateAttribute($value){

        $this->attributes['repeateddate'] = date('Y/m/d', strtotime($value));

    }

}
