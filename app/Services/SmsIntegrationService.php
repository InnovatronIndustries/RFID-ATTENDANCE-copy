<?php

namespace App\Services;

use App\Models\User;

class SmsIntegrationService
{
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
}