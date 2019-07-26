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


class ProcessController extends Controller
{

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

            if (!top20_mode()) {
                $request->validate([
                    'best_girl' => 'required|exists:stars,name',
                    'best_night' => 'required|exists:stars,name',
                ]);

                $best_girl = Star::where('name', $request->best_girl)->first();
                $best_girl->assign_award($trophies[0]);

                $best_night = Star::where('name', $request->best_night)->first();
                $best_night->assign_award($trophies[1]);
            }

            if ( cm()!=12 || (cm()==12 && top20_mode()) ) {
                $prixes = Point::tops(cy(), cmn(), 5);
                $ranks = Point::tops(cy(), 'sum', 3);

                foreach ($prixes as $i => $star) {
                    $star->assign_award($trophies[$i+2]);
                }

                foreach ($ranks as $i => $star) {
                    $star->assign_award($trophies[$i+7]);
                }
            }

            $current_setting = Setting::first();
            $message = Setting::next_month();

            return redirect("prixes/$current_setting->current_year")->withMessage($message);

        }else {
            return back()->withError("Trophies Required : ". implode(',', $trophies))->withInput();
        }
    }

}
