<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Client extends Model
{
    protected $guarded = [];

    protected $casts = [
    	'tag' => 'array',
    	'category' => 'array'
    ];

}
