<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class AppController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('app');
    }
}
