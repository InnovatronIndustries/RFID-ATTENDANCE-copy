<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function addEmployee(Request $request){
        $inputFields=$request->all();
        //ensure that all of the employee fields are filled before placing data into database
        if(empty($inputFields)){
            return response()->json(["success"=>false]);
        }
        Employee::create([
            'uid'=>$inputFields['uid'],
            'school'=>$inputFields['school'],
            'firstname'=>$inputFields['firstname'],
            'middlename'=>$inputFields['middlename'],
            'lastname'=>$inputFields['lastname'],
            'role'=>$inputFields['role'],
        ]);
        return response()->json(["success"=>true]);
    }
    public function removeEmployee(Request $request){
        $uidToDelete=$request->input('uid');
        
    }
    //**************************************************************************
   /*public function addStudent(){
        
    }*/


    //***********************************************************************//
    public function getMembers(Request $request){
        $result=DB::table('employees')
            ->select('uid','school','firstname','middlename','lastname','role', 'avatar')
            ->where('status','=','active')
            ->unionAll(DB::table('students')
                ->select('uid','school','firstname','middlename','lastname','role', 'avatar')
                ->where('status','=','active')
            )
        ->get();
        if(empty($result)){
            return response()->json(["success="=>false]);
        }
        return response()->json(["success"=>true,"data"=>$result]);
    }
}
