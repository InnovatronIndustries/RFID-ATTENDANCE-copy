<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogOutController extends Controller
{
    public function logout(Request $request)
    {
        $uidToCheck = $request->input('uid');

        if (!$this->isValidUid($uidToCheck)) {
            return response()->json(['error' => 'Invalid UID'], 401);
        }

        $currentDateTime = Carbon::now();
        $loggedInUser = Session::get('logged_in_user');

        if ($loggedInUser === $uidToCheck) {
            // User is logged in, create a logout record and remove the session variable
            $this->storeLogoutTime($uidToCheck, $currentDateTime);
            Session::forget('logged_in_user');
            return response()->json(['message' => 'Logged out']);
        }

        return response()->json(['message' => 'Not logged in']);
    }

    public function checkLogoutCondition(Request $request)
    {
        $uidToCheck = $request->input('uid');

        if (!$this->isValidUid($uidToCheck)) {
            return response()->json(['error' => 'Invalid UID'], 401);
        }

        $currentDateTime = Carbon::now();
        $latestLogin = $this->getLatestLogin($uidToCheck);

        if ($latestLogin && $this->shouldLogout($latestLogin, $currentDateTime)) {
            return response()->json(['shouldLogout' => true]);
        }

        

        return response()->json(['shouldLogout' => false]);
    }

    private function getLatestLogin($uid)
    {
        return LoginLog::where('uid', $uid)
            ->whereDate('log_date', Carbon::today())
            ->where('type', 'In')
            ->orderBy('log_date', 'desc')
            ->first();
    }

    private function shouldLogout($loginRecord, $currentDateTime)
    {
        $loginTime = Carbon::parse($loginRecord->log_date);
        $minutesSinceLastLogin = $loginTime->diffInMinutes($currentDateTime);
        return $minutesSinceLastLogin >= 5;
    }

    private function isValidUid($uidToCheck)
    {
        // Implement your UID validation logic here
        // Return true if the UID is valid, or false otherwise.
        return true;
    }

    private function storeLogoutTime($uidToCheck, $currentDateTime)
    {
        LoginLog::create([
            'uid' => $uidToCheck,
            'type' => "Out",
            'log_date' => $currentDateTime,
        ]);

        Log::info('Logout time stored in database:', ['uid' => $uidToCheck, 'log_date' => $currentDateTime]);
    }
}
