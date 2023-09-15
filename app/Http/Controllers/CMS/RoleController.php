<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/access-management/roles';
    }

    public function index()
    {
        $roles = Role::all();
        return view($this->baseView . '/index', compact('roles'));
    }
}
