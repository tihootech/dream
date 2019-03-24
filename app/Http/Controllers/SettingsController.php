<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\BasePoint;
use App\Trophy;

class SettingsController extends Controller
{
    public function edit()
    {
        $base_points = BasePoint::all();
        $base_points []= new BasePoint;

        $trophies = Trophy::all();
        $trophies []= new Trophy;

        return view('dashboard.settings', compact('base_points', 'trophies'));
    }

    public function update_time(Request $request)
    {
        $request->validate([
            'cm' => 'numeric|min:1|max:12',
            'cy' => 'numeric|min:1',
        ]);
        $settings = Setting::first();
        $settings->current_month = $request->cm;
        $settings->current_year = $request->cy;
        $settings->save();
        return back()->withMessage("Month & Year Updated");
    }

    public function update_base_points(Request $request)
    {
        $data = prepare_multiple($request->all());
        BasePoint::truncate();
        BasePoint::insert($data);
        return back()->withMessage("Base Points Updated");
    }

    public function update_trophies(Request $request)
    {
        $data = prepare_multiple($request->all());
        Trophy::truncate();
        Trophy::insert($data);
        return back()->withMessage("Trophies Updated");
    }
}
