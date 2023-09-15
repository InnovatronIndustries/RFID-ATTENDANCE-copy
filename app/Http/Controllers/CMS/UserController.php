<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Auth, Storage;
use App\Models\{
    Role,
    User
};

class UserController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/access-management/users';
    }

    public function index()
    {
        $roles = Role::whereNotIn('id', [Role::SUPER_ADMIN])->oldest('name')->get();
        $users = User::whereNotIn('role_id', [Role::SUPER_ADMIN])
            ->oldest('firstname')
            ->withTrashed()
            ->get()
            ->map(function ($data) {
                $data->avatar = $data->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $data->avatar) : null;
                return $data;
            });

        return view($this->baseView . '/index', compact('roles', 'users'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('id', [Role::SUPER_ADMIN])->oldest('name')->get();
        return view($this->baseView . '/create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $schoolID = $this->currentSchoolID();

        $finalAvatar = 'student.png';
        if ($request->hasFile('avatar')) {
            $file = Storage::disk('s3')->put('uploads/avatar', $request->avatar);
            $filePath = Storage::disk('s3')->url($file);
            $finalAvatar = basename($filePath);
        }

        $user = new User;
        $user->school_id = $schoolID;
        $user->role_id = $request->role_id;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->avatar = $finalAvatar;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->uid = $request->uid;
        $user->save();

        return back()->with('success', 'User has been added successfully.');
    }

    public function edit(string $id)
    {
        $roles = Role::whereNotIn('id', [Role::SUPER_ADMIN])->oldest('name')->get();
        $user = User::findOrFail($id);

        return view($this->baseView . '/edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

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

        $user->role_id = $request->role_id;
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->avatar = $finalAvatar;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->uid = $request->uid;
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