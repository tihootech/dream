<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $guarded = ['id'];

    public function star()
    {
        return $this->belongsTo(Star::class, 'name', 'name');
    }

    public function star_id()
    {
        $star = Star::nfind($this->name);
        return $star->id ?? null;
    }

    public function age()
    {
        $birthday = $this->birthday ?? null;
        return $birthday ? Carbon::parse($birthday)->age : 0;
    }
}
