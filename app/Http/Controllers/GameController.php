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
        $limit = request('limit');

        $stars = Point::tops($year, $order, $limit);

        return view('game.result', compact('stars'));
    }

    public function process()
    {
        return view('game.process');
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

    public function quick_plus(Request $request)
    {
        $string = $request->string;
        $data = explode(',', $string);

        $name_string = $request->name ?? $data[0];
        $type = $request->type;
        $points = $data[1] ?? 0;
        $cloth = $data[2] ?? 0;
        $kid = $data[3] ?? null;

        $list = []; // to store stars object

        // no point case
        if (!$points) {
            return redirect('home')->withError("Please provide points")->withInput();
        }

        // create list array
        $names = explode('&', $name_string);
        $is_single = count($names) == 1;
        foreach ($names as $name) {
            $possible_stars = Star::where('name', 'like', "%$name%")->get();
            $count = count($possible_stars);
            if ($count < 1) {
                $error = $is_single ? "Nothing found" : "For One of them nothing found";
                return back()->withError($error)->withInput();
            }elseif( $count > 1 ) {
                if ($is_single) {
                    return view('game.possible_stars', compact('possible_stars', 'string', 'type'));
                }else {
                    return back()->withError('For One of them more than one star found')->withInput();
                }
            }else{
                $list []= $possible_stars->first();
            }
        }

        // loop through list and list contains star model instances
        $messages = ["Your string was : $string"];
        foreach ($list as $star) {
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
        }
        return redirect('home')->withList($list)->withMessages($messages)->withInput(compact('type'));

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

        return redirect('home')->withList([$star])->withMessages($messages);
    }

    public function master(Request $request)
    {
        if (base_point_exists('master')) {
            $request->validate([
                'star' => 'exists:stars,name',
                'degree' => 'numeric|min:1|max:10',
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
        $month = $year ? 12 : cm();
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
        for ($i=1; $i <= $month ; $i++) {
            $prixes_list [mn($i)]= Point::tops($year, mn($i), 5);
        }

        return view('game.prixes', compact('prixes_list', 'result'));
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

    public function change_room($sid, Request $request)
    {
        $star = Star::find($sid);
        $room = Room::where('block', $request->block)->where('number', $request->number)->first();
        if($room){
            $star->change_room($room->id);
            return back()->withMessage("Room Changed Successfully for $star->name");
        }
    }

    public function random($tops=null)
    {
        $filters = request('filters');
        $filtered_stars = $filters ? explode(',', $filters) : [];
        do {
            $star = Star::get_random($tops);
        }while( in_array($star->name, $filtered_stars) );

        return $star->name;
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
