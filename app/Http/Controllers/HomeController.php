<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Star;
use App\SemiFinal;
use App\FinalDay;
use App\Point;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mode =  top20_mode() ? 'top20' : 'home';
        if ($mode=='top20') {
            $semi_final = SemiFinal::current();
            $current_day = $semi_final ? FinalDay::where('semi_final_id', $semi_final->id)->max('day') : 1;
            $current_day++;
            $top20_stars = Point::topN(20);
            $duplicate_members = [];
            $all_members = [];
            for ($i=1; $i <=4 ; $i++) {
                $randoms = $top20_stars->random(4);
                foreach ($randoms as $random_star) {
                    if(in_array($random_star->name, $all_members)){
                        $duplicate_members []= $random_star->name;
                    }
                    $groups[$i][]= $all_members []= $random_star->name;
                }
            }
            return view('dashboard.main', compact('mode', 'semi_final', 'top20_stars', 'current_day', 'groups', 'all_members', 'duplicate_members'));
        }else {
            return view('dashboard.main', compact('mode'));
        }
    }
}
