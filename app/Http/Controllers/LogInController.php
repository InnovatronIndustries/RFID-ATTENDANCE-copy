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

class LogInController extends Controller
{
    protected $rfidService;

    public function __construct()
    {
        $this->rfidService = resolve(RfidService::class);
    }

    public function login(Request $request)
    {
        $uid = $request->input('uid');
        $currentDateTime = Carbon::now('Asia/Manila');

        if (!$uid) {
            return response()->json(['message' => 'User not found']);
        }

        // Get the latest record for the specified UID
        $latestRecord = RfidLog::whereUidAndType($uid, 'In')->latest('created_at')->first();

        if ($latestRecord) {
            $logDate = Carbon::parse($latestRecord->created_at, 'Asia/Manila');
            $timeDifferenceInSeconds = $currentDateTime->diffInSeconds($logDate);

            if ($timeDifferenceInSeconds < 3) {
                // The time difference is less than 3 seconds, don't log out
                return response()->json(['success' => false]);
            }
        }
         
        $this->storeLoginTime($uid, $currentDateTime);
        return response()->json(['success' => true, 'message' => 'Logged in']);
    }

    private function storeLoginTime($uid, $logDate)
    {
        RfidLog::create([
            'uid'      => $uid,
            'type'     => 'In',
            'log_date' => $logDate
        ]);

        Log::info('Login time stored in database:', ['uid' => $uid, 'log_date' => $logDate]);
    }


    public function getLoginTime($uid)
    {
        $user = User::whereUid($uid)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $response = $this->rfidService->getLogInformation($user, true);
        
        return response()->json($response);
    }

}
