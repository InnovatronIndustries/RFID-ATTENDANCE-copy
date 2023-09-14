<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class LogInController extends Controller
{
    public function login(Request $request)
    {
        $uidToCheck = $request->input('uid');
        $currentDateTime = Carbon::now('Asia/Manila');

        if (!$uidToCheck) {
            return response()->json(['message' => 'User not found']);
        }

        $this->storeLoginTime($uidToCheck, $currentDateTime);
        return response()->json(['success' => true, 'message' => 'Logged in']);
    }

    private function storeLoginTime($uidToCheck, $logDate)
    {
        LoginLog::create([
            'uid' => $uidToCheck,
            'type' => "In",
            'log_date' => $logDate,
        ]);

        Log::info('Login time stored in database:', ['uid' => $uidToCheck, 'log_date' => $logDate]);
    }


    public function getLoginTime($uid)
    {
        
        $result=DB::table('employees')
            ->select('uid','school','firstname','middlename','lastname','level','section','student_no','role', 'avatar')
            ->where('uid','=',$uid)
            ->unionAll(DB::table('students')
                ->select('uid','school','firstname','middlename','lastname','level','section','student_no','role', 'avatar')
                ->where('uid','=',$uid)
            )
        ->first();

        
        if (!$result) {
            return response()->json(['error' => 'User not found'], 404);
        }

        
        $currentDateTime = Carbon::now('Asia/Manila');

        
        $formattedDateTime = $currentDateTime->toIso8601String();

        return response()->json([
            'user' => $result,
            'log_date' => $formattedDateTime,
            'response' => true
        ]);
    }


}
