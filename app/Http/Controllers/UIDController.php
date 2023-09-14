<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; 


class UIDController extends Controller
{
    public function checkUID(Request $request)
    {
        $uidToCheck = $request->input('uid'); // Get the UID from the AJAX request

        // Query your database to check if the UID exists
        $user = Student::where('uid', $uidToCheck)->first();

        if ($user) {
            // UID exists, return user details
            return response()->json([
                'success' => true,
                'user' => $user
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


