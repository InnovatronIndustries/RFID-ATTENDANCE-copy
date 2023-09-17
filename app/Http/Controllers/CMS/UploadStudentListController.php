<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use DB, Excel;

class UploadStudentListController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/file-uploads';
    }

    public function index()
    {
        $data = [];
        return view($this->baseView . '/uploadStudentList', compact('data'));
    }

    public function store(Request $request)
    {
        // DB::beginTransaction();

        try {

            $file = $request->file('file');
            $schoolId = $this->currentSchoolID();
            $sheetName = 'ListImport';

            Excel::import(new StudentsImport($schoolId), $file, $sheetName);

            // DB::commit();
            return back()->with('success', 'File has been uploaded successfully.');

        } catch (\Exception $e) {
            // DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
