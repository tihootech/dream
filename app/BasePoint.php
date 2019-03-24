<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasePoint extends Model
{
    public static function get_for($number, $type)
    {
        $base = self::where('type', $type)->first();
        return $base ? $base->quantity * $number : $number;
    }
}
