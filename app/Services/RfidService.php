<?php

namespace App\Services;

use Carbon\Carbon, Storage;
use App\Models\{
    Role,
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
        $user->avatar = $user->avatar ? Storage::disk('s3')->url('uploads/avatar/' . $user->avatar) : null;
        $user->details = 'Employee No. '.$user->employee_code;
        if ($user->role_id == Role::STUDENT) {
            $level = $user->student->level?? '';
            $section = $user->student->section?? '';
            $studentNo = $user->student->student_no?? null;
            $lrn = $user->student->lrn?? null;

            $details = "$level - $section";
            $studentNo ? $details .= " | Student No. $studentNo" : '';
            $lrn && !$studentNo ? $details .= " | LRN: $lrn" : '';

            $user->details = $details;
        }
        
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->toIso8601String();

        return [
            'user'     => $user,
            'log_date' => $formattedDateTime,
            'response' => $responseType
        ];
    }
}