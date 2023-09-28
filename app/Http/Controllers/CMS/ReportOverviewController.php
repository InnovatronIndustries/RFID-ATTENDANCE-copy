<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportOverviewController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/reports-overview';
    }

    public function index()
    {
        return view($this->baseView . '/index');
    }
}
