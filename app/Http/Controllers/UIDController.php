<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;


class UIDController extends Controller
{
    public function checkUID(Request $request)
    {
        $uidToCheck = $request->input('uid'); // Get the UID from the AJAX request

        $result=DB::table('employees')
            ->select('uid','school','firstname','middlename','lastname','role', 'avatar')
            ->where('uid','=',$uidToCheck)
            ->unionAll(DB::table('students')
                ->select('uid','school','firstname','middlename','lastname','role', 'avatar')
                ->where('uid','=',$uidToCheck)
            )
        ->get();

        if ($result) {
            // UID exists, return user details
            return response()->json([
                'success' => true,
                'user' => $result
            ]);
        } else {
            // UID doesn't exist
            return response()->json([
                'success' => false,
                'message' => 'UID not found'
            ]);
        }
    }
}


