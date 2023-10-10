<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // TODO: 篩選公司、呈現RIR數據、計算結果


        return view('index');
    }
}
