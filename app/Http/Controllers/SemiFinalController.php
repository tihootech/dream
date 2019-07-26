<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SemiFinal;
use App\Star;
use App\FinalDay;

class SemiFinalController extends Controller
{
    public function store($type)
    {
    	return $this->$type();
    }

	public function initialize()
	{
		$data = request()->validate([
			'base' => 'required',
		]);
		$current = SemiFinal::current();
		if ($current) {
			$current->update($data);
			return back()->withMessage('Semi Final Updated Successfully');
		}else {
			$data['year'] = cy();
			SemiFinal::create($data);
			return back()->withMessage('Semi Final Initialized Successfully');
		}
	}

	public function start()
	{
        // validation
		$data = request()->validate([
			'performers.stars' => 'required',
			'announcer.stars' => 'required|exists:stars,name',
		]);

        // needed data
		$semi_final = SemiFinal::current();
        $performers_raw = $data['performers']['stars'];
		$performers = explode(',', $performers_raw);
		$announcer_name = $data['announcer']['stars'];
        $announcer = Star::nfind($announcer_name);
		$n_performer = ceil(request('performers')['ratio'] / count($performers));
		$n_announcer = request('announcer')['ratio'];

        // find stars
		foreach ($performers as $performer) {
			$found = Star::nfind($performer);
			if(!$found) return back()->withError("$performer does not exist");
			$stars []= $found;
		}

        // assign points
		foreach ($stars as $star) {
			$points = $n_performer * $semi_final->base;
			$star->assign_points($points, 'top20');
			$messages []= "$points added for $star->name";
		}
        $points = $n_announcer * $semi_final->base;
        $announcer->assign_points($points, 'top20');
        $messages []= "$points added for $announcer->name";

        // update semi final record
        $semi_final->performers = $performers_raw;
        $semi_final->announcer = $announcer_name;
        $semi_final->save();

		return back()->withMessages($messages);
	}

    public function days()
    {
        // needed data
        $semi_final = SemiFinal::current();
        $day_number = request('day');

        // determine inputs
        $inputs = [
            'morning_sex', 'secretary', 'best_kid', 'show', 'threesome', 'nightovers',
            'winner_1', 'winner_2', 'winner_3', 'winner_4', 'winner_overall'
        ];
        // validation
        foreach ($inputs as $input) {
            $stars_raw = request($input)['stars'];
            if(!$stars_raw){
                return back()->withError("Please provide $input")->withInput();
            }
            $star_names = explode(',', $stars_raw);
            foreach ($star_names as $star_name) {
                $found = Star::nfind($star_name);
                if(!$found){
                    return back()->withError("$star_name not found!")->withInput();
                }else {
                    $list[$input] []= $found;
                }
            }
        }

        // assign points & update days
        $day = $semi_final->recreate_day($day_number);
        foreach ($list as $input => $stars) {
            $stars_raw = request($input)['stars'];
            $points = floor( (request($input)['ratio'] * $semi_final->base)/count($stars) );
            foreach ($stars as $star) {
                $star->assign_points($points, 'top20');
            }
            $day->$input = $stars_raw;
            $messages []= nf($points)." for : $stars_raw as $input";
        }
        $day->save();

        // redirection
        return back()->withMessages($messages);
    }
}
