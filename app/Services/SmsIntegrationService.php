<?php

namespace App\Services;

use App\Models\{
    User,
    Role,
    RfidLog
};
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class SmsIntegrationService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ["Content-Type" => "application/json"],
            'verify' => false,
        ]);
    }

    /**
     * sendCallback
     *
     * @param string $accessToken
     * @param string $subscriberNo
     *
     * @return void
     *
     */
    public function sendCallback(string $accessToken, string $subscriberNo): void
    {
        $user = User::whereMobileNo($subscriberNo)->first();
        
        if ($user) {
            $user->sms_access_token = $accessToken?? null;
            $user->save();
        }
    }

    public function sendSms($uid, $dateTime, $school, $type = 'In')
    {
        $user = User::whereUid($uid)->first();

        if ($user && $user->role_id == Role::STUDENT) {

            $currentTimestamp = Carbon::now()->timestamp;
            $rcvdTransId = "AP-$currentTimestamp";

            $date = Carbon::now()->startOfDay();
            $currentDate = $date->format('M d, Y');
            $logTime = Carbon::parse($dateTime)->format('h:i A');

            $schoolName = $user->school->name?? 'Academe Portal';
            $studentName = $user->fullname;
            $logText = $type == 'In' ? "Log-in: $logTime" : "Log-out: $logTime";

            if ($school->is_enable_sms_only_for_logouts && $type == 'Out') {
                $loginLogDate = RfidLog::where('uid', $uid)
                    ->whereDate('log_date', Carbon::now()->toDateString())
                    ->where('type', 'In')
                    ->first()['log_date']?? Carbon::now();

                $loginTime = Carbon::parse($loginLogDate)->format('h:i A');
                $logText = "Log-in: $loginTime / Log-out: $logTime";
            }

            $message = "$schoolName $currentDate\n$studentName\n$logText\n\nvia Academe Portal";

            $url = "https://api.m360.com.ph/v3/api/broadcast";

            $payload = [
                'app_key'        => 'Gk4IU39uF58OG6GT',
                'app_secret'     => 'hnAEFsD01EKRqB9i',
                'msisdn'         => $user->contact_no,
                'content'        => $message,
                'shortcode_mask' => 'APAccess',
                'rcvd_trans_id'  => $rcvdTransId,
                'is_intl'        => false
            ];

            $this->client->post($url, ['json' => $payload]);
        }
    }

    /**
     * checkifMobileNoisValid
     *
     * @param string $mobileNo
     *
     * Regular expression to validate a Philippine mobile number starting with "09" or "639"
     */
    public function checkIfMobileNoisValid($mobileNo)
    {
        return preg_match('/^(09|639)\d{9}$/', $mobileNo);
    }
}