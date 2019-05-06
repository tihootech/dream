<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $guarded = ['id'];
    
    public function star()
    {
        return $this->belongsTo(Star::class);
    }
}
