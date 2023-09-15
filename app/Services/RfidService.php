<?php 

namespace App\Services;

use Carbon\Carbon, Storage;
use App\Models\{
    User
};

class RfidService
{
    /**
     * Get Log Information
     *
     * @param object $user
     * @param bool $responseType
     *
     * @return array|null
     */
    public function getLogInformation(object $user, bool $responseType): array|null
    {
        $level = $user->level?? 'Grade 1';
        $section = $user->section?? 'Mapayapa';
        $studentNo = $user->student_no?? '2021-2192';

        $user->avatar = $user->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $user->avatar) : null;
        $user->details = "$level - $section | Student/Employee No. $studentNo";
        
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toIso8601String();

        return [
            'user'     => $user,
            'log_date' => $formattedDateTime,
            'response' => $responseType
        ];
    }
}