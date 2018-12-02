<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cars_status extends Model
{
    protected $table = 'cars_status';

    public function cars()
    {
        return $this->hasMany('App\cars');
    }
}
