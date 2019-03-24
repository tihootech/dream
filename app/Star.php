<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{

    protected $guarded = ['id'];

    public static function find_or_add($name)
    {
        $existing_star = self::where('name',$name)->first();
        if ($existing_star) {
            return $existing_star;
        }else {
            $star = new self;
            $star->name = $name;
            $star->save();
            return $star;
        }
    }

    public function assign_points($numbers, $type='regular')
    {
        $numbers = explode('+', $numbers);
        if ($type=='kid') {
            $this->bring_kid($numbers);
        }
        $sum = 0;
        foreach ($numbers as $number) {
            $sum += $amount = BasePoint::get_for($number, $type);
            $point = new Point;
            $point->star_id = $this->id;
            $point->amount = $amount;
            $point->type = $type;
            $point->month = cm();
            $point->year = cy();
            $point->save();
        }
        return $sum;
    }

    public function bring_kid($input)
    {
        // input is array or a numeric value
        $numbers = is_numeric($input) ? [$input] : $input;
        
        foreach ($numbers as $number) {
            $kid = new Kid;
            $kid->level = $number;
            $kid->month = cm();
            $kid->year = cy();
            $kid->save();
        }
    }

}
