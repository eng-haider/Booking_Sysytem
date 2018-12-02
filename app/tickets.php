<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tickets extends Model
{
    protected $fillable = [
        'tenant_name','tenant_phone','car_type_id','trip_date','car_id','ticket_status_id','car_status_id','driver_id',
    ];
}
