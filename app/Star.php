<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Star extends Model
{

    protected $guarded = ['id'];

    public function qname()
    {
        return str_replace(' ','+',$this->name);
    }

    public static function nfind($name)
    {
        return self::where('name', $name)->first();
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    public function details()
    {
        return $this->hasOne(Detail::class, 'name', 'name');
    }

    public function recent_points()
    {
        return $this->hasMany(Point::class)->latest()->take(20);
    }

    public function change_room($room_id)
    {
        $this->room_id = $room_id;
        $this->save();
    }

    public function rank($type)
    {
        $tops = [];
        if ($type=='month') {
            $tops = self::tops(cy(), mn(cm()))->toArray();
        }
        if ($type=='year') {
            $tops = self::tops()->toArray();
        }
        $key = array_search($this->id, array_column($tops, 'id'));
        return $key+1;
    }

    public function age()
    {
        $birthday = $this->details->birthday ?? null;
        return $birthday ? Carbon::parse($birthday)->age : 0;
    }

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
            $amount = BasePoint::get_for($number, $type);
            $sum += $amount;
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

    // before you assign an award, you must check if trophy exists
    public function assign_award($title)
    {
        $trophy = Trophy::where('title', $title)->first();
        $award = new Award;
        $award->star_id = $this->id;
        $award->title = $title;
        $award->money = $trophy->price ?? 0;
        $award->month = cm();
        $award->year = cy();
        $award->save();
        return $award;
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
