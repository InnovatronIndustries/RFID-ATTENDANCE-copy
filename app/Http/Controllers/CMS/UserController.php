<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Auth, Storage;
use App\Models\{
    Role,
    School,
    User
};

class UserController extends Controller
{
    private $baseView;
    private $excludedRoleIds;

    public function __construct()
    {
        $this->baseView = 'cms/access-management/users';

        $this->excludedRoleIds = [
            Role::SUPER_ADMIN,
            Role::STUDENT
        ];
    }

    public function index()
    {
        $schoolID = $this->currentSchoolID();
        $roles = Role::whereNotIn('id', $this->excludedRoleIds)->oldest('name')->get();

        $schools = Auth::user()->role_id == Role::SUPER_ADMIN
            ? School::oldest('name')->get()
            : [];

        $users = User::whereNotIn('role_id', $this->excludedRoleIds)
            ->when(Auth::user()->role_id !== Role::SUPER_ADMIN, fn ($q) => $q->where('school_id', $schoolID))
            ->oldest('firstname')
            ->withTrashed()
            ->get()
            ->map(function ($data) {
                $data->avatar = $data->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $data->avatar) : null;
                return $data;
            });

        return view($this->baseView . '/index', compact('schools', 'roles', 'users'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('id', $this->excludedRoleIds)->oldest('name')->get();
        $schools = Auth::user()->role_id == Role::SUPER_ADMIN
            ? School::oldest('name')->get()
            : [];

        return view($this->baseView . '/create', compact('roles', 'schools'));
    }

    public function store(UserRequest $request)
    {
        $schoolID = $request->school_id?? $this->currentSchoolID();

        $finalAvatar = 'student.png';
        if ($request->hasFile('avatar')) {
            $file = Storage::disk('s3')->put('uploads/avatar', $request->avatar);
            $filePath = Storage::disk('s3')->url($file);
            $finalAvatar = basename($filePath);
        }

        $user = new User;
        $user->school_id = $schoolID == 0 ? null : $schoolID;
        $user->role_id = $request->role_id;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->avatar = $finalAvatar;
        $user->username = $request->username?? null;
        $user->email = $request->email;
        $user->password = $request->password?? 'password';
        $user->uid = $request->uid;
        $user->address = $request->address?? null;
        $user->position = $request->position?? null;
        $user->employee_code = $request->employee_code?? null;
        $user->contact_person = $request->contact_person?? null;
        $user->contact_no = $request->contact_no?? null;
        $user->save();

        return back()->with('success', 'User has been added successfully.');
    }

    public function edit(string $id)
    {
        $roles = Role::whereNotIn('id', $this->excludedRoleIds)->oldest('name')->get();
        $schools = Auth::user()->role_id == Role::SUPER_ADMIN
            ? School::oldest('name')->get()
            : [];

        $user = User::findOrFail($id);

        return view($this->baseView . '/edit', compact('roles', 'schools', 'user'));
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $schoolID = $request->school_id?? $this->currentSchoolID();

        $finalAvatar = $user->avatar;
        if ($request->hasFile('avatar')) {
            $avatarExists = Storage::disk('s3')->exists('uploads/avatar/' . $finalAvatar);
            if (!empty($finalAvatar && $avatarExists)) {
                if (!in_array($finalAvatar, ['admin.png', 'coordinator.png', 'faculty.png', 'master.png', 'school-admin.png', 'student.png'])) {
                    Storage::disk('s3')->delete('uploads/avatar/' . $finalAvatar);
                }
            }

            $file = Storage::disk('s3')->put('uploads/avatar', $request->avatar);
            $filePath = Storage::disk('s3')->url($file);
            $finalAvatar = basename($filePath);
        }

        $user->school_id = $schoolID == 0 ? null : $schoolID;
        $user->role_id = $request->role_id;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->avatar = $finalAvatar;
        $user->username = $request->username?? null;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->uid = $request->uid;
        $user->address = $request->address?? null;
        $user->position = $request->position?? null;
        $user->employee_code = $request->employee_code?? null;
        $user->contact_person = $request->contact_person?? null;
        $user->contact_no = $request->contact_no?? null;
        $user->save();

        return back()->with('success', 'User has been updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->save();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User has been deleted successfully.');
    }
}
