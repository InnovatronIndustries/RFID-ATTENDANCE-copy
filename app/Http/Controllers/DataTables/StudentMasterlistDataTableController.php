<?php

namespace App\Http\Controllers\DataTables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables, Storage;
use App\Models\{
    Student
};

class StudentMasterlistDataTableController extends Controller
{
    public function index(Request $request)
    {
        $schoolID = $this->currentSchoolID();
        $students = Student::whereSchoolId($schoolID)
            ->with('user:id,avatar,uid,firstname,middlename,lastname,contact_no,email,created_at')
            ->get()
            ->map(function ($data) {
                $data->avatar = $data->user->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $data->user->avatar) : null;
                $data->level_section = $data->level.' - '.$data->section;
                $data->formatted_created_at = $data->user->formatted_created_at;
                return $data;
            });

        return DataTables::of($students)
            ->addColumn('student_links', function ($data) {
                return [
                    'fullname' => $data->user->fullname,
                    'edit_link' => route('student-masterlist.edit', ['student_masterlist' => $data->id])
                ];
            })
            ->rawColumns(['student_links'])
            ->make(true);
    }
}
