<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubdomainTestController extends Controller
{
    public function index($schoolName)
    {
        return "school subdomain: $schoolName";
    }
}
