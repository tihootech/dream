<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Award;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::latest()->get();
        return view('awards.index', compact('awards'));
    }
}
