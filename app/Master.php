<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    public static function make($star_id, $degree)
    {
        $master = new self;
        $master->star_id = $star_id;
        $master->degree = $degree;
        $master->month = cm();
        $master->year = cy();
        $master->save();
        return $master;
    }
}
