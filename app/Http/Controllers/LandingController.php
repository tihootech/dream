<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Star;
use App\Point;
use App\BasePoint;
use App\Master;
use App\Award;
use App\Setting;
use App\Competition;
use App\Winner;
use App\Detail;
use App\Room;

class LandingController extends Controller
{
    public function events(Request $request)
    {
        // get all different types in points
        $types = Point::select('type')->distinct()->get()->toArray();
        $types = array_map('current', $types);

        // build query
        $points = Point::query();
        if ($sid = $request->sid) {
            $points = $points->where('star_id', $sid);
        }
        if ($type = $request->type) {
            $points = $points->where('type', $type);
        }

        // order
        if ($order = request('order')) {
            $otype = request('otype') ?? 'DESC';
            $points = $points->orderBy($order, $otype);
        }else {
            $points = $points->latest();
        }

        // return view
        $points = $points->paginate(50);
        return view('game.events', compact('points', 'types'));
    }

    public function birthdays()
    {
        $details = Detail::orderBy('birthday')->get();
        $result = Detail::select('*', \DB::raw('RIGHT(birthday,2) as day'))->whereNotNull('birthday')->orderBy('day')->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->birthday)->format('m');
        })->sortKeys();
        return view('game.birthdays', compact('result'));
    }

    public function rooms()
    {
        $rooms = Room::orderBy('block')->orderBy('number')->get();
        return view('game.rooms', compact('rooms'));
    }


    public function competition($year=null, Request $request)
    {
        if(!$year) $year = cy();
        $change = $request->change;
        $competitions = Competition::all();
        return view('game.competition', compact('competitions', 'change', 'year'));
    }
}
