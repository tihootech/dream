<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Award;
use App\Trophy;
use App\Star;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::latest()->paginate(25);
        $trophies = Trophy::all();
        return view('awards.index', compact('awards','trophies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'star' => 'required|exists:stars,name',
            'trophy' => 'required|exists:trophies,id',
        ]);
        $star = Star::nfind($request->star);
        $trophy = Trophy::find($request->trophy);
        $star->assign_award($trophy->title);
        $message = "$trophy->title trophy assigned to $star->name";
        return back()->withMessage($message);
    }
}
