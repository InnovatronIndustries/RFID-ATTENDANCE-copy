<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Storage;
use App\Services\RfidService;
use App\Services\SmsIntegrationService;
use App\Models\{
    RfidLog,
    School,
    User
};

class LogOutController extends Controller
{
    protected $rfidService;
    protected $smsIntegrationService;

    public function __construct()
    {
        $this->rfidService = resolve(RfidService::class);
        $this->smsIntegrationService = resolve(SmsIntegrationService::class);
    }

    public function logout(Request $request)
    {
        $uid = $request->uid;
        $currentDateTime = Carbon::now();

        if (!$uid) {
            return response()->json(['message' => 'User not found']);
        }

        $subdomain = strtolower($this->getSchoolSubdomain());
        $school = School::whereRfidSubdomain($subdomain)->first();
        $maxSmsCredits = $school->max_sms_credits;
        $maxUserSmsPerDay = $school->max_user_sms_per_day;

        // Get the latest record for the specified UID
        $latestRecord = RfidLog::whereUidAndType($uid, 'In')->latest('created_at')->first();

        if ($latestRecord) {
            $logDate = Carbon::parse($latestRecord->created_at, 'Asia/Manila');
            $timeDifferenceInSeconds = $currentDateTime->diffInSeconds($logDate);

            if ($timeDifferenceInSeconds < 300) {
                // The time difference is less than 5 minutes, don't log out
                return response()->json(['success' => false]);
            }
        }

        $totalSmsCount = RfidLog::where('uid', $uid)
            ->whereDate('log_date', Carbon::now()->toDateString())
            ->where('is_sms_sent', true)
            ->count();

        $isSmsSent = false;
        $mobileNo = User::whereUid($uid)->first()['contact_no']?? '';
        $isMobileNoValid = $this->smsIntegrationService->checkIfMobileNoisValid($mobileNo);

        if ($maxSmsCredits == 0 || $maxSmsCredits > $totalSmsCount) {
            if ($isMobileNoValid && $school->is_sms_enabled && ($maxUserSmsPerDay == 0 || $maxUserSmsPerDay > $totalSmsCount)) {
                $sendSmsSuccess = $this->smsIntegrationService->sendSms($uid, $currentDateTime, $school, 'Out');
                if ($sendSmsSuccess) {
                    $isSmsSent = true;
                    $school->increment('sms_credits_used');
                    $school->save();
                }
            }
        }
         
        $this->storeLogoutTime($uid, $currentDateTime, $isSmsSent);
        return response()->json(['success' => true, 'message' => 'Logged out']);
    }

    private function storeLogoutTime($uid, $logDate, $isSmsSent)
    {
        RfidLog::create([
            'uid'         => $uid,
            'type'        => 'Out',
            'log_date'    => $logDate,
            'is_sms_sent' => $isSmsSent
        ]);
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

        // prevent logout if the user forgot to logout on the previous day.. new logs should be considered as "In"
        if (!$latestRecord || !Carbon::parse($latestRecord->created_at)->isToday()) {
            return response()->json(['success' => false]);
        }

        if ($latestRecord->type === 'In') {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
