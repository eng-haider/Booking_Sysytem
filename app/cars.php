<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cars extends Model
{
  
    
    protected $fillable = [
        'car_num','car_type_id','car_status_id','car_color_id','notes','seats_num','driver_status_id'
    ];

    public function cars_type()
    {
        return $this->belongsTo('App\cars_status');
    }

    public function cars_status()
    {
        return $this->belongsTo('App\cars_type');
    }

    public function cars_colors()
    {
        return $this->belongsTo('App\cars_colors');
    }


}
