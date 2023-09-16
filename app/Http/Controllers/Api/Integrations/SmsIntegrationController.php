<?php

namespace App\Http\Controllers\Api\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

use App\Services\{
    ApiLogService,
    SmsIntegrationService
};

class SmsIntegrationController extends Controller
{

    protected $smsIntegrationService;
    protected $apiLogService;

    public function __construct()
    {
        $this->smsIntegrationService = resolve(SmsIntegrationService::class);
        $this->apiLogService = resolve(ApiLogService::class);
    }

    /**
     * sendCallback API (webhook)
     *
     * Redirect URI - This link will receive the Code parameter if via web form, or Access Token if via SMS.
     *
     * Code parameter: required to get your subscriber’s Access Token. This is sent to your Redirect URI, and access it via GET.
     *
     * After the subscriber replies (Yes), the Access Token and the Subscriber’s mobile number will be sent to your Redirect URI,
     * you can get these parameters via GET method.
     *
     * Sample GET to Redirect URI:
     * - GET /?access_token=E1enKbxfLBUH7b_1E500G_V16fM-Yxmm1VHAR15Re9I&subscriber_number=9179471234 HTTP/1.1
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function sendCallback(Request $request): JsonResponse
    {
        $accessToken = $request->query('access_token', null);
        $subscriberNo = $request->query('subscriber_number', null);

        try {

            $data = $request->all();
            $this->apiLogService->saveApiLogs(url('/sms-callback'), $data, 'globe-sms');

            $this->smsIntegrationService->sendCallback($accessToken, $subscriberNo);
            return response()->json(['message' => 'success'], 200);

        } catch (\Throwable $e) {

            $data = [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ];

            Log::info($data);
            return response()->json($data, 500);
        }
    }
}
