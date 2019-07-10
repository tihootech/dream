<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Star;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mode = top20_mode() ? 'top20' : 'home';
        return view('dashboard.main', compact('mode'));
    }
}
