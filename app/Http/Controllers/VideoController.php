<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __invoke()
    {
        return view('admin.video');
    }
}
