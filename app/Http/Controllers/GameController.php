<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Star;
use App\Point;
use App\BasePoint;
use App\Master;
use App\Award;
use App\Setting;

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

        $stars = Star::tops($year, $order);

        return view('game.result', compact('stars'));
    }

    public function process()
    {
        return view('game.process');
    }

    public function next_month(Request $request)
    {
        $trophies = [
            'Best Girl Of The Month', // 0
            'Best Night Of The Month', // 1
            'Golden Prix', // 2
            'Silver Prix', // 3
            'Bronze Prix', // 4
            'Position Prix', // 5
            'Position Prix', // 6
            'Golden Rank', // 7
            'Silver Rank', // 8
            'Bronze Rank', // 9
        ];

        if (trophies_exist($trophies)) {

            $request->validate([
                'best_girl' => 'required|exists:stars,name',
                'best_night' => 'required|exists:stars,name',
            ]);

            $best_girl = Star::where('name', $request->best_girl)->first();
            $best_girl->assign_award($trophies[0]);

            $best_night = Star::where('name', $request->best_night)->first();
            $best_night->assign_award($trophies[1]);

            $prixes = Star::tops(cy(), cmn(), 5);
            $ranks = Star::tops(cy(), 'sum', 3);

            foreach ($prixes as $i => $star) {
                $star->assign_award($trophies[$i+2]);
            }

            foreach ($ranks as $i => $star) {
                $star->assign_award($trophies[$i+7]);
            }

            Setting::next_month();

            return redirect('prixes')->withMessage('Next month process completed.');

        }else {
            return back()->withError("Trophies Required : ". implode(',', $trophies))->withInput();
        }
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

    public function prixes()
    {
        $awards = Award::where('title', 'like', '%Prix')->orWhere('title', 'like', '%Rank')->get();
        return view('game.prixes');
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
