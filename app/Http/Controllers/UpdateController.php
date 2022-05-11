<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class UpdateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('installer');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function install()
    {
        return view('install');
    }
}
