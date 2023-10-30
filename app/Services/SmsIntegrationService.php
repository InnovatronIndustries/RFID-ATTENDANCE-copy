<?php

namespace App\Services;

use App\Models\{
    User,
    Role
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

    public function sendSms($uid, $dateTime, $type = 'In')
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
}