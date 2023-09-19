<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
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
        $schoolID = $this->currentSchoolID();
        $roleID = Auth::user()->role_id;

        $queryCondition = function ($q) use ($roleID, $schoolID) {
            if ($roleID !== Role::SUPER_ADMIN) {
                return $q->where('school_id', $schoolID);
            }
            
            return $q;
        };

        $totalUsers = User::where('role_id', '<>', Role::SUPER_ADMIN)->when($queryCondition)->count();
        $totalStudents = User::whereRoleId(Role::STUDENT)->when($queryCondition)->count();
        $totalEmployees = User::whereRoleId(Role::STAFF)->when($queryCondition)->count();

        return view($this->baseView . '/index', compact('totalUsers', 'totalStudents', 'totalEmployees'));
    }
}
