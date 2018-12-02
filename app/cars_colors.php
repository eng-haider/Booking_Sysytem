<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cars_colors extends Model
{
    public function cars()
    {
        return $this->hasMany('App\cars');
    }
}

