<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseMember;
use Illuminate\Http\Request;
use App\Models\OfflineCourse;
use App\Models\CategoryCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    private $ctitle = "Dashboard";
    private $view_path = "member.pages.dashboard.";
    private $routes_path;
    private $has_access = "dashboard";

    public function __construct()
    {
        $this->routes_path = route('member.dashboard.index') . "/";
    }

    public function get_etc()
    {
        $data = array();
        $data = $this->meta_data($data);
        $data['ctitle'] = $this->ctitle;
        $data['croute'] = $this->routes_path;
        $data['has_access'] = $this->has_access;
        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->get_etc();

        $course_member = $this->get_course_by_member();
        $count_cart = Cart::where('user_id', '=', info_user_id())->count();
        $offline_courses = $this->get_offline_course_by_member();

        return view($this->view_path . "index", compact('data', 'course_member', 'offline_courses', 'count_cart'));
    }










    //------------------------------
    //----------DATA----------------
    //------------------------------
    public function get_course_by_member()
    {
        $results_data = Course::select(
            'courses.*',
            'l.name as level_name',
        )
            ->rightJoin('course_members as cm', 'cm.course_id', '=', 'courses.id')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->where('cm.member_id', info_user_id())
            ->whereNull('cm.deleted_at')
            ->take(4)
            ->get();
        return $results_data;
    }

    public function get_offline_course_by_member()
    {
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $results_data = OfflineCourse::whereHas('registrars', function ($query) {
            $query->where('user_id', '=', info_user_id());
        })
            ->where('date_time_end', '>=', $currentDate)
            ->orderBy('date_time_start', 'DESC')
            ->get();
        return $results_data;
    }
}
