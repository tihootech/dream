<?php

namespace App\Http\Controllers;

use App\Star;
use App\Detail;
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
        $fields = \DB::getSchemaBuilder()->getColumnListing('details');
        array_shift($fields);array_pop($fields);array_pop($fields);
        return view('stars.edit', compact('star', 'fields'));
    }

    public function update(Request $request, Star $star)
    {
        $data = $request->validate([
            'name' => "unique:stars,name,$star->id"
        ]);
        $star->update($data);
        if ($star->details) {
            $star->details->update($request->details);
        }else {
            Detail::create($request->details);
        }
        return back()->withMessage("Star Updated");
    }

    public function destroy(Star $star)
    {
        $star->delete();
        // \DB::table('points')->where('star_id', $star->id)->delete();
        return back()->withMessage("Only the star herself deleted. her points are still in database. her id was $star->id");
    }

}
