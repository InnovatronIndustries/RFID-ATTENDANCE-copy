<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogInController extends Controller
{
    public function login(Request $request)
    {
        $uidToCheck = $request->input('uid');

        if (!$this->isValidUid($uidToCheck)) {
            return response()->json(['error' => 'Invalid UID'], 401);
        }

        $currentDateTime = Carbon::now('Asia/Manila');
        $loggedInUser = Session::get('logged_in_user');

        if ($loggedInUser === $uidToCheck) {
            // User is already logged in, don't create a new login record
            return response()->json(['message' => 'Already Logged in']);
        }

        $latestLogin = LoginLog::where('uid', $uidToCheck)
            ->where('type', 'In')
            ->orderBy('log_date', 'desc')
            ->first();

        if ($latestLogin) {
            // Check if the user has logged out within the last 5 minutes
            $timeDifference = $currentDateTime->diffInMinutes($latestLogin->log_date);
            if ($timeDifference < 5) {
                // User has logged out recently, so don't create a new login record
                Session::put('logged_in_user', $uidToCheck);
                return response()->json(['message' => 'Already Logged In']);
            }
        }

        // Create a new login record
        $this->storeLoginTime($uidToCheck, $currentDateTime);
        Session::put('logged_in_user', $uidToCheck);

        return response()->json(['message' => 'Logged in']);
    }

    private function isValidUid($uidToCheck)
    {
        // Implement your UID validation logic here
        // Return true if the UID is valid, or false otherwise.
        return true;
    }

    private function storeLoginTime($uidToCheck, $logDate)
    {
        LoginLog::create([
            'uid' => $uidToCheck,
            'type' => "In",
            'log_date' => $logDate, // Use $logDate instead of $currentDateTime
        ]);

        Log::info('Login time stored in database:', ['uid' => $uidToCheck, 'log_date' => $logDate]);
    }


    public function getLoginTime(Request $request)
    {

        // Perform any necessary checks or validation here.
        $currentDateTime = Carbon::now('Asia/Manila');

        // Format the date as ISO 8601 (e.g., "2023-09-12T14:30:00+08:00")
        $formattedDateTime = $currentDateTime->toIso8601String();

        return response()->json(['log_date' => $formattedDateTime]);
    }




}
