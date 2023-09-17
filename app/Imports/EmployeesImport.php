<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\{
    Role,
    User
};

class EmployeesImport implements ToModel, WithHeadingRow
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
        if (!isset($row['lastname']) || isset($row['student_id'])) {
            return null;
        }

        $roleID = Role::STAFF;

        return User::updateOrCreate([
            'employee_code'  => $row['employee_code']
        ], [
            'role_id'        => $roleID,
            'school_id'      => $this->schoolId,
            'uid'            => null,
            'employee_code'  => $row['employee_code']?? null,
            'department'     => $row['department']?? null,
            'position'       => $row['position']?? null,
            'firstname'      => $row['firstname'],
            'middlename'     => $row['middle_name']?? $row['middlename']?? null,
            'lastname'       => $row['lastname'],
            'gender'         => 'Male',
            'avatar'         => null,
            'contact_person' => $row['contact_person']?? null,
            'contact_no'     => $row['contact_no']?? $row['mobile_phone']?? null,
            'birthdate'      => null,
            'address'        => $row['address']?? null,
            'email'          => $row['email']?? null,
            'password'       => 'password',
            'avatar'         => 'student.png'
        ]);
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
