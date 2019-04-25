<?php

namespace App\Http\Controllers;

use App\Star;
use Illuminate\Http\Request;

class StarController extends Controller
{

    public function index()
    {
        $stars = Star::all();
        return view('stars.index', compact('stars'));
    }

    public function show(Star $star)
    {
        return view('stars.show', compact('star'));
    }

    public function edit(Star $star)
    {
        return view('stars.edit', compact('star'));
    }

    public function update(Request $request, Star $star)
    {
        $data = $request->validate([
            'name' => "unique:stars,name,$star->id"
        ]);
        $star->update($data);
        return redirect('stars')->withMessage("Star Updated");
    }

    public function destroy(Star $star)
    {
        $star->delete();
        \DB::table('points')->where('star_id', $star->id)->delete();
        return back()->withMessage('Only the star herself and her points deleted.');
    }

}
