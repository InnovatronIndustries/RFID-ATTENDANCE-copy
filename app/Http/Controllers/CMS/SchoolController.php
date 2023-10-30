<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolRequest;
use DB, Storage;
use App\Models\{
    School
};

class SchoolController extends Controller
{
    private $baseView;
    private $s3LogoPath;
    private $s3BannerPath;

    public function __construct()
    {
        $this->baseView = 'cms/manage-schools';
        $this->s3LogoPath = Storage::disk('s3')->url('uploads/logo/');
        $this->s3BannerPath = Storage::disk('s3')->url('uploads/banner/');
    }

    public function index()
    {
        $schools = School::all()
            ->map(function ($data) {
                $data->logo = $data->logo ? $this->s3LogoPath . $data->logo : $this->s3LogoPath . 'ap-logo.png';
                $data->banner = $data->banner ? $this->s3BannerPath . $data->banner : asset('bg.jpg');
                return $data;
            });

        return view($this->baseView . '/index', compact('schools'));
    }

    public function create()
    {
        return view($this->baseView . '/create');
    }

    public function store(SchoolRequest $request)
    {
        $finalLogo = '';
        if ($request->hasFile('logo')) {
            $file = Storage::disk('s3')->put('uploads/logo', $request->logo);
            $filePath = Storage::disk('s3')->url($file);
            $finalLogo = basename($filePath);
        }

        $finalBanner = '';
        if ($request->hasFile('banner')) {
            $file1 = Storage::disk('s3')->put('uploads/banner', $request->banner);
            $filePath1 = Storage::disk('s3')->url($file1);
            $finalBanner = basename($filePath1);
        }

        $school = new School;
        $school->name = $request->name;
        $school->address = $request->address;
        $school->logo = $finalLogo?? '';
        $school->banner = $finalBanner?? '';
        $school->rfid_subdomain = strtolower($request->rfid_subdomain);
        $school->max_user_sms_per_day = 2;
        $school->max_sms_credits = 0;
        $school->is_sms_enabled = false;
        $school->save();

        return back()->with('success', 'School has been added successfully.');
    }

    public function edit(string $id)
    {
        $school = School::findOrFail($id);
        $school->logo = $school->logo ? $this->s3LogoPath . $school->logo : $this->s3LogoPath . 'ap-logo.png';
        $school->banner = $school->banner ? $this->s3BannerPath . $school->banner : asset('bg.jpg');

        return view($this->baseView . '/edit', compact('school'));
    }

    public function update(SchoolRequest $request, string $id)
    {
        $school = School::findOrFail($id);

        $finalLogo = $school->logo;
        if ($request->hasFile('logo')) {
            $logoExists = Storage::disk('s3')->exists('uploads/logo/' . $finalLogo);
            if (!empty($finalLogo && $logoExists)) {
                Storage::disk('s3')->delete('uploads/logo/' . $finalLogo);
            }

            $file = Storage::disk('s3')->put('uploads/logo', $request->logo);
            $filePath = Storage::disk('s3')->url($file);
            $finalLogo = basename($filePath);
        }

        $finalBanner = $school->banner;
        if ($request->hasFile('banner')) {
            $bannerExists = Storage::disk('s3')->exists('uploads/banner/' . $finalBanner);
            if (!empty($finalBanner && $bannerExists)) {
                Storage::disk('s3')->delete('uploads/banner/' . $finalBanner);
            }

            $file1 = Storage::disk('s3')->put('uploads/banner', $request->banner);
            $filePath1 = Storage::disk('s3')->url($file1);
            $finalBanner = basename($filePath1);
        }

        $school->name = $request->name;
        $school->address = $request->address;
        $school->logo = $finalLogo?? '';
        $school->banner = $finalBanner?? '';
        $school->rfid_subdomain = strtolower($request->rfid_subdomain);
        $school->max_user_sms_per_day = $request->max_user_sms_per_day;
        $school->max_sms_credits = $request->max_sms_credits;
        $school->is_sms_enabled = $request->is_sms_enabled?? false;
        $school->save();

        return back()->with('success', 'School updated successfully.');
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {

            $school = School::findOrFail($id);
            $isActive = false;
            $message = 'deactivated';

            if (!$school->is_active) {
                $isActive = true;
                $message = 'activated';
            }

            $school->is_active = $isActive;
            $school->save();

            DB::commit();
            return back()->with('success', 'School ' . $message . ' successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            report($e->getMessage());
            return back()->with('error', 'Something went wrong! Please try again later.');
        }
    }
}
