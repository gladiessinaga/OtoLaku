<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporMasalahController extends Controller
{
     public function index()
{
    return view('user.lapor-masalah');
}
}
