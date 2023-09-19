<?php

namespace App\Http\Controllers\DataTables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, DataTables, Storage;
use App\Models\{
    Role,
    User
};

class UserDataTableController extends Controller
{
    private $excludedRoleIds;

    public function __construct()
    {
        $this->excludedRoleIds = [
            Role::SUPER_ADMIN,
            Role::STUDENT
        ];
    }

    public function index(Request $request)
    {
        $schoolID = $this->currentSchoolID();
        $users = User::whereNotIn('role_id', $this->excludedRoleIds)
            ->when(Auth::user()->role_id !== Role::SUPER_ADMIN, fn ($q) => $q->where('school_id', $schoolID))
            ->oldest('firstname')
            ->withTrashed()
            ->get()
            ->map(function ($data) {
                $data->avatar = $data->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $data->avatar) : null;
                $data->fullname = '<a href="'.route('users.edit', ['user' => $data->id]).'">'. $data->fullname . '</a>';
                $data->role_name = $data->role->name;
                $data->school_name = $data->school->name?? 'N/A';
                $data->status = $data->is_active ? 'Active' : 'Inactive';
                $data->formatted_created_at = $data->formatted_created_at;
                $data->formatted_updated_at = $data->formatted_updated_at;

                return $data;
            });

        return DataTables::of($users)
            ->rawColumns(['fullname'])
            ->make(true);
    }

}
