<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function home()
    {
        return view('home');
    }

}
