<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Auth, Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function currentSchoolID()
    {
        return Auth::user()->school_id?? 0;
    }

    public function getSchoolSubdomain()
    {
        return Arr::first(explode('.', request()->getHost()));
    }

    public function getSchoolLogo($reqSchoolID = null)
    {
        $schoolID = $reqSchoolID?? $this->currentSchoolID();
        $logo = Storage::disk('s3')->url('uploads/logo/ap-logo.png');
        $school = School::find($schoolID);

        if ($school && $school->logo) {
            $logo = Storage::disk('s3')->url('uploads/logo/' . $school->logo);
        }

        return $logo;
    }
}

