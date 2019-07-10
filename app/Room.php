<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['id'];

    public function mark_as_empty()
    {
        $this->status = 1;
        $this->save();
    }

    public function mark_as_accepting()
    {
        $this->status = 2;
        $this->save();
    }

    public function mark_as_full()
    {
        $this->status = 3;
        $this->save();
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    public function translate_status()
    {
        switch ($this->status) {
            case 1: return 'empty'; break;
            case 2: return 'accepting'; break;
            case 3: return 'full'; break;
            default: return null; break;
        }
    }

}
