<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\OfflineCourseRegistrar;
use App\Models\OfflineCourseAttendance;

class ReportController extends Controller
{
    public function offline_course()
    {
        $total_offline_course_registrar = OfflineCourseRegistrar::all()->count();
        $total_offline_course_attendance = OfflineCourseAttendance::all()->count();

        return view('admin.pages.report.offline_course', [
            'total_offline_course_registrar' => $total_offline_course_registrar,
            'total_offline_course_attendance' => $total_offline_course_attendance,
        ]);
    }

    public function registrar_offline_course()
    {
        return view('admin.pages.report.registrar_offline_course');
    }
}
