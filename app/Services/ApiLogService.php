<?php 

namespace App\Services;

use Carbon\Carbon;
use Storage;

class ApiLogService
{
    /**
     * Save API Logs
     *
     * @param $url
     * @param $payload
     * @param $folderName
     * @param $response
     *
     * @return void
     */
    public function saveApiLogs($url, $payload, $folderName = 'api', $response = null): void
    {
        $today = Carbon::now();

        $content = [
            'request_url'      => $url,
            'request_body'     => $payload?? [],
            'request_headers'  => request()->header()?? [],
            'response_headers' => $response ? $response->getHeaders() : [],
            'response_body'    => $response ? $response->getBody()->getContents() : [],
            'created_at'       => $today->format('Y-m-d H:i:s')
        ];

        $year = $today->format('Y');
        $month = $today->format('M');
        $day = $today->format('d');

        $filename = $today->format('Ymd_His_u');
        $file = "logs/$folderName/$year/$month/$day/$filename.txt";

        Storage::disk('s3')->put($file, json_encode($content));
    }
}