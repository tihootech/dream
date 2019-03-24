<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Star;
use App\Point;
use App\BasePoint;
use App\Master;

class GameController extends Controller
{

    public function search(Request $request)
    {
        $stars = Star::where('name', 'like', "%$request->ps%")->get();
        return redirect('home')->withStars($stars);
    }

    public function result($year=null)
    {
        $year = $year ?? cy();
        $order = request('order') ?? cmn();

        $query = "stars.*, SUM(points.amount) as sum";
        for ($i=1; $i <=12 ; $i++) {
            $query .= ", (SELECT SUM(IF(points.month=$i, points.amount, 0))) AS ". mn($i);
        }
        $stars = Star::select(\DB::raw($query))
            ->where('year', $year)
            ->leftJoin('points', 'points.star_id', '=', 'stars.id')
            ->orderBy($order, 'DESC')
            ->groupBy('stars.id')
            ->get();

        return view('game.result', compact('stars'));
    }

    public function process()
    {
        return view('game.process');
    }

    public function quick_plus(Request $request)
    {
        $string = $request->string;
        $data = explode(',', $string);

        $name = $request->name ?? $data[0];
        $regular = $data[1] ?? null;
        $cloth = $data[2] ?? null;
        $kid = $data[3] ?? null;

        if (!$regular) {
            return redirect('home')->withError("Please provide regular points")->withInput();
        }

        $possible_stars = Star::where('name', 'like', "%$name%")->get();
        $count = count($possible_stars);

        if ($count == 0) {
            return redirect('home')->withError("Nothing found")->withInput();
        }
        if ($count > 1) {
            return view('game.possible_stars', compact('possible_stars', 'string'));
        }
        if ($count == 1) {
            $star = $possible_stars->first();
            $messages []= "Your string was : $string";
            if ($regular > 0) {
                $sum = $star->assign_points($regular);
                $messages []= "$sum added for $star->name as regular";
            }
            if ($cloth) {
                $sum = $star->assign_points($cloth, 'cloth');
                $messages []= "$sum added for $star->name as cloth";
            }
            if ($kid) {
                $sum = $star->assign_points($kid, 'kid');
                $messages []= "$sum added for $star->name as kid";
            }
            return redirect('home')->withMessages($messages);
        }

    }

    public function quick_add(Request $request)
    {
        if (!Star::where('name', $request->star)->first()) {
            $messages []= "$request->star Added To Stars List";
        }
        $star = Star::find_or_add($request->star);

        if ($request->points) {
            $sum = $star->assign_points($request->points);
            $messages []= nf($sum)." points added for $star->name as regular";
        }
        if ($request->kids) {
            $sum = $star->assign_points($request->kids, 'kid');
            $messages []= nf($sum)." points added for $star->name because of her kids.";
        }

        return redirect('home')->withMessages($messages);
    }

    public function master(Request $request)
    {
        if (base_point_exists('master')) {
            $request->validate([
                'star' => 'exists:stars,name',
                'degree' => 'numeric|min:1|max:6',
            ]);
            $star = Star::where('name', $request->star)->first();
            Master::make($star->id, $request->degree);
            $star->assign_points($request->degree, 'master');
            $point = Point::latest()->first();
            $message = "You masterbated on $star->name with degree of $request->degree and she gained ".nf($point->amount)." points.";
            return back()->withMessage($message);
        }else {
            return back()->withError('Base Point "master" does not exist');
        }
    }


    public function events()
    {
        $points = Point::latest()->paginate(50);
        return view('game.events', compact('points'));
    }

    public function delete_point(Point $point)
    {
        $point->delete();
        return back()->withMessage(nf($point->amount)." points reduced from {$point->star->name}");
    }

    public function edit_point(Point $point, Request $request)
    {
        if ($new_amount = $request->new_amount) {
            $point->amount = $new_amount;
            $point->save();
            return redirect('events')->withMessage('Point edited');
        }else {
            return view('game.edit_point', compact('point'));
        }
    }
}
