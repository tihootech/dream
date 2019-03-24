<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public function star()
    {
        return $this->belongsTo(Star::class);
    }
}
