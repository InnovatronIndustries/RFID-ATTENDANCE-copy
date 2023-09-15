<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{
    User
};

class UIDController extends Controller
{
    public function checkUID(Request $request)
    {
        $user = User::whereUid($request->uid)->first();
        $data = ['success' => false, 'message' => 'UID not found'];

        if ($user) {
            $data = ['success' => true, 'message' => $user];
        }

        return response()->json($data);
    }
}


