<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

    public function winners_in($year)
    {
        return Winner::where('competition_id', $this->id)->where('year', $year)->get();
    }

    public function winner($rank,$year)
    {
        return Winner::where('competition_id', $this->id)->where('rank', $rank)->where('year', $year)->first();
    }
}
