<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function index()
    {
        return view('website.survei');
    }
}
