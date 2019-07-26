<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public static function next_month()
    {
        $setting = self::first();
        if (cm() != 12) {
            $setting->current_month++;
            $message = "Next Month process completed.";
        }else {
            if (top20_mode()) {
                $setting->current_month = 1;
                $setting->current_year++;
                $setting->top20_mode = false;
                $message = "Year finished successfully.";
            }else {
                $setting->top20_mode = true;
                $message = "Top20 Mode activated.";
            }
        }
        $setting->save();
        return $message;
    }
}
