<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

    public function get_rank($rank,$year)
    {
        $winner = $this->winner($rank,$year);
        return $winner ? ($winner->star->name ?? null) : null;
    }

    public function winner($rank,$year)
    {
        return Winner::where('competition_id', $this->id)->where('rank', $rank)->where('year', $year)->first();
    }
}
