<?php

namespace App\Http\Controllers\CMS\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    RfidLog,
    School,
    Student,
    User
};

class AttendanceReportController extends Controller
{
    private $baseView;

    public function __construct()
    {
        $this->baseView = 'cms/reports-overview/attendance-report';
    }

    public function index(Request $request)
    {
        $schoolID = $this->currentSchoolID();
        $school = School::findOrFail($schoolID);

        $levelAndSections = Student::select('level', 'section')
            ->whereSchoolId($schoolID)
            ->distinct()
            ->get();

        $levels = $levelAndSections->pluck('level')->unique()->sort()->values()->toArray();
        $sections = $levelAndSections->pluck('section')->unique()->sort()->values()->toArray();

        $selectedLevel = $request->query('level', null);
        $selectedSection = $request->query('section', null);
        $selectedLevelSection = null;
        $from = $request->query('from', null);
        $to = $request->query('to', null);

        $logs = [];
        if ($selectedLevel) {
            $selectedLevelSection = $selectedLevel.' - '.$selectedSection;
            $logs = RfidLog::whereHas('user.student', function ($q) use ($selectedLevel, $selectedSection, $schoolID) {
                $q->where('level', $selectedLevel)
                    ->when($selectedSection, function ($q) use ($selectedSection) {
                        $q->where('section', $selectedSection);
                    })
                    ->where('school_id', $schoolID)
                    ->whereNotNull('uid');
            })
            ->when($from && $to, function ($q) use ($from, $to) {
                $q->whereDate('log_date', '>=', date('Y-m-d', strtotime($from)))
                    ->whereDate('log_date', '<=', date('Y-m-d', strtotime($to)));
            })
            ->with('user.student')
            ->get();
        }

        $data = [
            'school_logo'          => $this->getSchoolLogo(),
            'from'                 => $request->query('from', null),
            'to'                   => $request->query('to', null),
            'levels'               => $levels,
            'sections'             => $sections,
            'logs'                 => $logs,
            'selectedLevel'        => $selectedLevel,
            'selectedSection'      => $selectedSection,
            'selectedLevelSection' => $selectedLevelSection
        ];

        return view($this->baseView . '/index', compact('school', 'data'));
    }
}
