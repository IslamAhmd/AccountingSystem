<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRepo extends Model
{
    protected $table = 'employees_repos';

    protected $guarded = [];
}
