<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReportOfflineCourseController extends Controller
{
    public function offline_course()
    {
        return view('admin.pages.report.offline_course.index');
    }

    public function registrar_offline_course()
    {
        return view('admin.pages.report.registrar_offline_course.index');
    }
}
