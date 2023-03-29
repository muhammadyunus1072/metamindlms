<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfflineCourse;
use App\Models\CategoryCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OfflineCourseController extends Controller
{
    public function index(Request $request)
    {
        return view('member.pages.master.offline_course.index');
    }
}
