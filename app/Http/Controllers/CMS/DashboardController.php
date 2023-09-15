<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Role,
    User
};

class DashboardController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/dashboard';
    }

    public function __invoke()
    {
        $totalUsers = User::where('role_id', '<>', Role::SUPER_ADMIN)->count();
        $totalStudents = User::whereRoleId(Role::STUDENT)->count();

        return view($this->baseView . '/index', compact('totalUsers', 'totalStudents'));
    }
}
