<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SemiFinal extends Model
{
    protected $guarded = ['id'];

    public static function current()
    {
    	return self::where('year', cy())->first();
    }

    public function recreate_day($day_number)
    {
        FinalDay::where('semi_final_id', $this->id)->where('day', $day_number)->delete();
        $day = new FinalDay;
        $day->semi_final_id = $this->id;
        $day->day = $day_number;
        return $day;
    }

    public function extract($type,$day)
    {
        $final_day = FinalDay::where('semi_final_id', $this->id)->where('day', $day)->first();
        return $final_day->$type ?? null;
    }
}
