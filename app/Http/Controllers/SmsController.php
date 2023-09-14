<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import the HTTP facade if not already imported

class SmsController extends Controller
{
    public function sendSms()
    {
        $shortcode = "21661551";
        $passphrase = "xxxxx12345";
        $app_id = "go8eIgrBEoC7kcR8jrTB8GCdXoqrIdBe";
        $app_secret = "dfc208d383ad1cf1be3a7995766a0e9e716404ad7627a44f80d73146155cb4e2";
        $address = "09458236715";
        $message = "PHP SMS Test";

        $response = Http::post("https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/" . $shortcode . "/requests?app_id=" . $app_id . "&app_secret=" . $app_secret . "&passphrase=" . $passphrase, [
            "outboundSMSMessageRequest" => [
                "senderAddress" => $shortcode,
                "outboundSMSTextMessage" => ["message" => $message],
                "address" => $address,
            ],
        ]);

        if ($response->failed()) {
            return "cURL Error #: " . $response->status();
        } else {
            return $response->body();
        }
    }
}
