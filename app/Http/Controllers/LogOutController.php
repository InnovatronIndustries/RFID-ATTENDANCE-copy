<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Services\RfidService;
use App\Models\{
    RfidLog,
    User
};

class LogOutController extends Controller
{
    protected $rfidService;

    public function __construct()
    {
        $this->rfidService = resolve(RfidService::class);
    }

    public function logout(Request $request)
    {
        $uid = $request->uid;
        $currentDateTime = Carbon::now();

        if (!$uid) {
            return response()->json(['message' => 'User not found']);
        }

        // Get the latest record for the specified UID
        $latestRecord = RfidLog::whereUidAndType($uid, 'In')->latest('created_at')->first();

        if ($latestRecord) {
            $logDate = Carbon::parse($latestRecord->created_at, 'Asia/Manila');
            $timeDifferenceInSeconds = $currentDateTime->diffInSeconds($logDate);

            if ($timeDifferenceInSeconds < 5) {
                // The time difference is less than 3 seconds, don't log out
                return response()->json(['success' => false]);
            }
        }
         
        $this->storeLogoutTime($uid, $currentDateTime);

        return response()->json(['success' => true, 'message' => 'Logged out']);
    }

    private function storeLogoutTime($uid, $logDate)
    {
        RfidLog::create([
            'uid'      => $uid,
            'type'     => 'Out',
            'log_date' => $logDate
        ]);

        Log::info('Logout time stored in database:', ['uid' => $uid, 'log_date' => $logDate]);
    }

    public function getLogoutTime($uid)
    {
        $user = User::whereUid($uid)->first();
 
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $response = $this->rfidService->getLogInformation($user, false);

        return response()->json($response);
    }

    public function shouldLogout(Request $request)
    {
        $latestRecord = RfidLog::whereUid($request->uid)->latest('created_at')->first();

        if (!$latestRecord) {
            return response()->json(['success' => false]);
        }

        if ($latestRecord->type === 'In') {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
