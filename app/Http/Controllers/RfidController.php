<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\{
    School
};

class RfidController extends Controller
{
    private $s3LogoPath;
    private $s3BannerPath;

    public function __construct()
    {
        $this->s3LogoPath = Storage::disk('s3')->url('uploads/logo/');
        $this->s3BannerPath = Storage::disk('s3')->url('uploads/banner/');
    }

    public function __invoke()
    {
        $subdomain = strtolower($this->getSchoolSubdomain());
        $school = School::whereRfidSubdomain($subdomain)->first();

        if (!$school) {
            return redirect()->route('login')->with('error', 'Unable to view rfid attendance page - this school is not yet registered. Please contact your administrator.');
        }

        $school->logo = $school->logo ? $this->s3LogoPath . $school->logo : $this->s3LogoPath . 'ap-logo.png';
        $school->banner = $school->banner ? $this->s3BannerPath . $school->banner : asset('bg.jpg');
        
        return view('index', compact('school'));
    }
}
