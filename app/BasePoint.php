<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasePoint extends Model
{
    // type like master, kid, ...
    // number is like level 3 kid or master with 3 degree
    public static function get_for($number, $type)
    {
        $base = self::where('type', $type)->first();
        return $base ? $base->quantity * $number : $number;
    }
}
