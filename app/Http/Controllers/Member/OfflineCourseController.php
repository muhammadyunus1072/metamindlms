<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\OfflineCourse;
use App\Models\CategoryCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OfflineCourseController extends Controller
{
    public function index()
    {
        return view('member.pages.offline_course.index');
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $offlineCourse = OfflineCourse::find($id);

        return view('member.pages.offline_course.show', ['offlineCourse' => $offlineCourse]);
    }
}
