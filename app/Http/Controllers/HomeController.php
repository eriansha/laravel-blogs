<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $name = "Ivan";
        return view('home', compact('name'));
    }
}
