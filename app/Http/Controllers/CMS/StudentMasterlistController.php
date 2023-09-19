<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Storage;
use App\Models\{
    Role,
    Student,
    User
};

class StudentMasterlistController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/student-masterlist';
    }

    public function index()
    {
        return view($this->baseView . '/index');
    }

    public function create()
    {
        return view($this->baseView . '/create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $schoolID = $this->currentSchoolID();

            $finalAvatar = 'student.png';
            if ($request->hasFile('avatar')) {
                $file = Storage::disk('s3')->put('uploads/avatar', $request->avatar);
                $filePath = Storage::disk('s3')->url($file);
                $finalAvatar = basename($filePath);
            }

            $user = new User;
            $user->school_id = $schoolID;
            $user->role_id = Role::STUDENT;
            $user->uid = $request->uid;
            $user->firstname = $request->firstname;
            $user->middlename = $request->middlename;
            $user->lastname = $request->lastname;
            $user->avatar = $finalAvatar;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->contact_person = $request->contact_person;
            $user->contact_no = $request->contact_no;
            $user->address = $request->address?? null;
            $user->email = $request->email?? null;
            $user->password = 'password';
            $user->save();

            $student = new Student;
            $student->school_id = $schoolID;
            $student->user_id = $user->id;
            $student->lrn = $request->lrn;
            $student->student_no = $request->student_no;
            $student->level = $request->level;
            $student->section = $request->section;
            $student->save();

            DB::commit();
            return response()->json(['type' => 'Student Enlistment', 'message' => 'Student enlisted successfully!'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            report($e->getMessage());
            return response()->json(['type' => 'Student Enlistment', 'message' => 'Something went wrong, please try again later.'], 500);
        }
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id)->load('user');
        $student->avatar = $student->user->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $student->user->avatar) : null;

        return view($this->baseView . '/edit', compact('student'));
    }

    public function update(Request $request, string $studentId)
    {
        DB::beginTransaction();

        try {

            $user = User::find($request->user_id);

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

            $user->uid = $request->uid;
            $user->firstname = $request->firstname;
            $user->middlename = $request->middlename;
            $user->lastname = $request->lastname;
            $user->avatar = $finalAvatar;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->contact_person = $request->contact_person;
            $user->contact_no = $request->contact_no;
            $user->address = $request->address?? null;
            $user->email = $request->email?? null;
            $user->save();

            $student = Student::findOrFail($studentId);
            $student->lrn = $request->lrn;
            $student->student_no = $request->student_no;
            $student->level = $request->level;
            $student->section = $request->section;
            $student->save();

            DB::commit();
            return response()->json(['type' => 'Student Enlistment', 'message' => 'Student Information updated successfully!'], 201);

        } catch (\Exception $e) {
            DB::rollback();
            report($e->getMessage());
            return response()->json(['type' => 'Student Enlistment', 'message' => 'Something went wrong, please try again later.'], 500);
        }
    }

    public function destroy(string $id)
    {
        // TODO
    }
}
