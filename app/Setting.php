<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public static function next_month()
    {
        $setting = self::first();
        $setting->current_month++;
        $setting->save();
    }
}
