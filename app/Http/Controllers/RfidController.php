<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RfidController extends Controller
{
    public function __invoke()
    {
        // TODO - support dynamic sub domain mapping
        return view('index');
    }
}
