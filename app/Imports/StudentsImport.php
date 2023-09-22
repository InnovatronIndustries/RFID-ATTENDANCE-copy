<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\{
    Role,
    Student,
    User
};

class StudentsImport implements ToModel, WithHeadingRow
{
    private $schoolId;
    
    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if a specific field exists in the row (e.g., 'name')
        // Skip processing
        if (!isset($row['last_name']) || isset($row['employee_code'])) {
            return null;
        }

        $roleID = Role::STUDENT;

        $level = null;
        $section = null;
        if ($row['grade_level_section']) {
            // Split the input string by the first occurrence of "-"
            $parts = explode("-", $row['grade_level_section'], 2);
            if (count($parts) == 2) {
                $level = isset($parts[0]) ? trim($parts[0]) : null;
                $section = isset($parts[1]) ? trim($parts[1]) : null;
            }
        }

        $email = $row['email_address']?? $row['email_adress']?? null;
        if ($email && $email === '-NO INFO-') {
            $email = null;
        }

        // remove vlookup formulas
        $email = stripos($email, 'VLOOKUP') !== false ? null : $email;
        $contactPerson = stripos($row['contact_person'], 'VLOOKUP') !== false ? null : $row['contact_person']?? null;
        $contactNo = stripos($row['contact_number'], 'VLOOKUP') !== false ? null : $row['contact_number']?? null;

        $lastName = $row['last_name']?? $row['lastname']?? null;
        $firstName = $row['first_name']?? $row['fisrt_name']?? null;
        $middleName = $row['middle_name']?? $row['middlename']?? null;

        $avatar = $lastName.'_'.$firstName.'.jpg';

        // check if student already exists
        $user = User::updateOrCreate([
            'lastname'       => $lastName,
            'firstname'      => $firstName,
            'middlename'     => $middleName
        ], [
            'role_id'        => $roleID,
            'school_id'      => $this->schoolId,
            'email'          => $email,
            'password'       => 'password',
            'gender'         => 'Male',
            'lastname'       => $lastName,
            'firstname'      => $firstName,
            'middlename'     => $middleName,
            'suffix'         => $row['suffix']?? null,
            'contact_person' => $contactPerson,
            'contact_no'     => $contactNo,
            'uid'            => $row['rfid']?? null,
            'birthdate'      => $row['birthdate']?? null
        ]);

        // Check if the user doesn't already have an avatar
        if (!$user->avatar) {
            $user->avatar = $avatar;
            $user->save();
        }

        Student::updateOrCreate([
            'user_id' => $user->id
        ], [
            'school_id'  => $this->schoolId,
            'user_id'    => $user->id,
            'lrn'        => $row['lrn']?? null,
            'student_no' => $row['student_id']?? null,
            'level'      => $level,
            'section'    => $section
        ]);

        return null;
    }

    /**
     * Specify the sheet name to import.
     *
     * @return string
     */
    public function getSheetName(): string
    {
        return 'ListImport';
    }
}
