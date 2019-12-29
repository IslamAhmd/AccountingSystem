<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\User;

class Employee extends Model
{
    protected $guarded = [];

   // check if the user is acitve or not 
    public function getActiveAttribute($value){

    	$user = User::where('email', $this->email)->first();

    	if(Auth::id() == $user->id){
    		return 1;
    	} else {
    		return 0;
    	}
    }
}
