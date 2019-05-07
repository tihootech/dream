<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Star;
use App\Point;
use App\BasePoint;
use App\Master;
use App\Award;
use App\Setting;
use App\Competition;
use App\Winner;

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

    public function competition($year=null, Request $request)
    {
        if(!$year) $year = cy();
        $change = $request->change;
        $competitions = Competition::all();
        $result = [];
        foreach ($competitions as $competition) {
            $result[$competition->id]= Winner::where('year', $year)->where('competition_id', $competition->id)->orderBy('rank')->get();
        }
        return view('game.competition', compact('competitions', 'result', 'change', 'year'));
    }

    public function save_competition(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'competition_id' => 'required|exists:competitions,id',
            'rank.*' => 'required|exists:stars,name',
        ]);
        $competition = Competition::find($request->competition_id);
        foreach ($request->rank as $rank => $name) {

            $data = [];
            $star = Star::nfind($name);
            $data['star_id'] = $star->id;
            $data['competition_id'] = $competition->id;
            $data['year'] = $request->year;
            $data['rank'] = $rank;
            $data['points'] = $competition->base * (12/$rank) * 2500;
            $data['money'] = $competition->base * (12/$rank) * 10000;

            if ($request->points) {
                $star->assign_points($data['points'], 'competition');
            }

            if ($winner = $competition->winner($rank,$request->year)) {
                $winner->update($data);
            }else {
                Winner::create($data);
            }

        }
        return redirect('competition')->withMessage('Changes Saved');
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
        $type = $request->type;
        $points = $data[1] ?? 0;
        $cloth = $data[2] ?? 0;
        $kid = $data[3] ?? null;

        if (!$points) {
            return redirect('home')->withError("Please provide points")->withInput();
        }

        $possible_stars = Star::where('name', 'like', "%$name%")->get();
        $count = count($possible_stars);

        if ($count == 0) {
            return redirect('home')->withError("Nothing found")->withInput();
        }
        if ($count > 1) {
            return view('game.possible_stars', compact('possible_stars', 'string', 'type'));
        }
        if ($count == 1) {
            $star = $possible_stars->first();
            $messages []= "Your string was : $string";
            if ($points > 0) {
                $sum = $star->assign_points($points, $type);
                $messages []= "$sum added for $star->name as $type";
            }
            if ($cloth > 0) {
                $sum = $star->assign_points($cloth, 'cloth');
                $messages []= "$sum added for $star->name as cloth";
            }
            if ($kid) {
                $sum = $star->assign_points($kid, 'kid');
                $messages []= "$sum added for $star->name as kid";
            }
            return redirect('home')->withMessages($messages)->withInput(compact('type'));
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
        if ($request->cloth) {
            $sum = $star->assign_points($request->cloth, 'cloth');
            $messages []= nf($sum)." points added for $star->name as cloth";
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

    public function prixes($year=null)
    {
        $year = $year ?? cy();

        // grand prix result
        $stars = Star::all();
        $result = [];
        foreach ($stars as $star) {
            $golds = Award::where('title','Golden Prix')->where('star_id', $star->id)->where('year', $year)->count();
            $silvers = Award::where('title','Silver Prix')->where('star_id', $star->id)->where('year', $year)->count();
            $bronzes = Award::where('title','Bronze Prix')->where('star_id', $star->id)->where('year', $year)->count();
            $positions = Award::where('title','Position Prix')->where('star_id', $star->id)->where('year', $year)->count();
            $money =
                ($golds * money_for_award('Golden Prix')) +
                ($silvers * money_for_award('Silver Prix')) +
                ($bronzes * money_for_award('Bronze Prix')) +
                ($positions * money_for_award('Position Prix'));
            $result[$star->id]['star'] = $star->name;
            $result[$star->id]['golds'] = $golds;
            $result[$star->id]['silvers'] = $silvers;
            $result[$star->id]['bronzes'] = $bronzes;
            $result[$star->id]['positions'] = $positions;
            $result[$star->id]['money'] = $money;
        }
        $result = sort_prixes($result);
        $rank = 1;
        for ($i=0; $i < count($result) ; $i++) {
            $result[$i]['rank'] = $rank;
            if (isset($result[$i+1]) && $result[$i]['money'] != $result[$i+1]['money']) {
                $rank = $i+2;
            }
        }

        // get prixes with points
        $prxies = [];
        for ($i=1; $i < cm() ; $i++) {
            $prixes_list [mn($i)]= Star::tops($year, mn($i), 5);
        }

        return view('game.prixes', compact('prixes_list', 'result'));
    }

    public function events(Request $request)
    {
        $points = Point::query();
        if ($sid = $request->sid) {
            $points = $points->where('star_id', $sid);
        }
        $points = $points->latest()->paginate(50);
        return view('game.events', compact('points'));
    }

    public function delete_point(Point $point)
    {
        $point->delete();
        return back()->withMessage(nf($point->amount)." points reduced from {$point->star->name}");
    }

    public function edit_point(Point $point, Request $request)
    {
        if ($request->update) {
            $point->amount = $request->new_amount;
            $point->type = $request->new_type;
            $point->save();
            return redirect('events')->withMessage('Point edited');
        }else {
            return view('game.edit_point', compact('point'));
        }
    }

    public function sync($name)
    {
        $star = Star::where('name', $name)->first();
        $cm = cm();
        if ($star && $star->details && $star->details->id) {
            $points = \DB::table('old_points')->where('star_id', $star->details->id)->get();
            $sum = $points->sum('amount');
            return redirect('home')->withMessage("Points to sync for $star->name : $sum");
        }
        return redirect('home')->withMessage("Nothing to sync");
    }
}
