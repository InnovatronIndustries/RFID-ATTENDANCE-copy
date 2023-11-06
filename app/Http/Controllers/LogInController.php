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

class LogInController extends Controller
{
    protected $rfidService;
    protected $smsIntegrationService;

    public function __construct()
    {
        $this->rfidService = resolve(RfidService::class);
        $this->smsIntegrationService = resolve(SmsIntegrationService::class);
    }

    public function login(Request $request)
    {
        $uid = $request->input('uid');
        $currentDateTime = Carbon::now('Asia/Manila');

        if (!$uid) {
            return response()->json(['message' => 'User not found']);
        }

        $subdomain = strtolower($this->getSchoolSubdomain());
        $school = School::whereRfidSubdomain($subdomain)->first();
        $maxSmsCredits = $school->max_sms_credits;
        $maxUserSmsPerDay = $school->max_user_sms_per_day;
        $isEnableSmsOnlyForLogouts = $school->is_enable_sms_only_for_logouts;

        // Get the latest record for the specified UID
        $latestRecord = RfidLog::whereUidAndType($uid, 'Out')->latest('created_at')->first();

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
            if (!$isEnableSmsOnlyForLogouts && $isMobileNoValid && $school->is_sms_enabled && ($maxUserSmsPerDay == 0 || $maxUserSmsPerDay > $totalSmsCount)) {
                $sendSmsSuccess = $this->smsIntegrationService->sendSms($uid, $currentDateTime, $school, 'In');
                if ($sendSmsSuccess) {
                    $isSmsSent = true;
                    $school->increment('sms_credits_used');
                    $school->save();
                }
            }
        }
         
        $this->storeLoginTime($uid, $currentDateTime, $isSmsSent);
        return response()->json(['success' => true, 'message' => 'Logged in']);
    }

    private function storeLoginTime($uid, $logDate, $isSmsSent)
    {
        RfidLog::create([
            'uid'         => $uid,
            'type'        => 'In',
            'log_date'    => $logDate,
            'is_sms_sent' => $isSmsSent
        ]);
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
