<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = ['name', 'import_num', 'starts_at', 'ends_at', 'budget', 'client_id', 'employee_id', 'shipment_num', 'container_data', 'shipment_date', 'arrival_date', 'abstract_name', 'abstract_num', 'shipment_location', 'doc_credit_num', 'gurantee_letter_num'];
}
