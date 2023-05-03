<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CourseMember;
use App\Exports\RecapCourse;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMemberLesson;
use App\Models\CourseReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    private $ctitle = "Report";
    private $routes_path;

    private $title_course_member = "Kursus Member";
    private $view_path_course_member = "admin.pages.report.course_member.";
    private $has_access_course_member = "report_course_member";

    private $title_recap_course = "Rekap Kursus";
    private $view_path_recap_course = "admin.pages.report.recap_course.";
    private $has_access_recap_course = "report_recap_course";


    public function __construct()
    {
        $this->routes_path = route('admin.report.index') . "/";
    }

    public function get_etc()
    {
        $data = array();
        // $data = $this->meta_data($data);
        $data['ctitle'] = $this->ctitle;
        $data['croute'] = $this->routes_path;

        $data['title_course_member'] = $this->title_course_member;
        $data['title_recap_course'] = $this->title_recap_course;

        $data['has_access_course_member'] = $this->has_access_course_member;
        return $data;
    }








    // Course Member
    public function course_member(Request $request)
    {
        $data = $this->get_etc();

        $list_rating = CourseReview::LIST_RATING;
        $list_progress = CourseMemberLesson::LIST_PROGRESS;

        return view($this->view_path_course_member . 'index', [
            "data" => $data,
            "list_rating" => $list_rating,
            "list_progress" => $list_progress,
        ]);
    }

    public function json_course_member(Request $request)
    {
        if ($request->ajax()) {
            $asset = DB::table('view_course_member');
            $asset = $asset->select(
                'view_course_member.*',
            )
                ->when($request->daterange, function ($query) use ($request) {
                    $date = explode(" - ", $request->daterange);
                    $start_date = sql_datef($date[0]) . " 00:00:00";
                    $end_date = sql_datef($date[1]) . " 23:59:59";
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                })
                ->when($request->member_id, function ($query) use ($request) {
                    $member_id = dec($request->member_id);
                    $query->where('member_id', $member_id);
                })
                ->when($request->course_id, function ($query) use ($request) {
                    $course_id = dec($request->course_id);
                    $query->where('course_id', $course_id);
                })
                ->when($request->rating, function ($query) use ($request) {
                    $query->where('course_review_rating', $request->rating);
                })
                ->when($request->progress, function ($query) use ($request) {
                    $progress = explode(" - ", $request->progress);
                    $min_progress = $progress[0];
                    $max_progress = $progress[1];
                    $query->whereBetween('progress', [$min_progress, $max_progress]);
                });
            return DataTables::of($asset)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('course_title', 'like', $search_value)
                                ->orWhere('member_name', 'like', $search_value)
                                ->orWhere('course_review_rating', 'like', $search_value);
                        });
                    }
                })
                ->addColumn('vprogress', function ($row) {
                    $view = $row->progress . '%';
                    return $view;
                })
                ->addColumn('vrating', function ($row) {
                    $view = '<span><i class="fas fa-star text-danger"></i>  ' . ($row->course_review_rating ?? '-') . '</span>';
                    return $view;
                })
                ->addColumn('created_date', function ($row) {
                    $view = timestampf($row->created_at);
                    return $view;
                })
                ->smart(true)
                ->startsWithSearch()
                ->rawColumns(['vprogress', 'vrating', 'created_date', 'action'])
                ->toJson();
        }
    }

    public function export_course_member(Request $request)
    {
        return Excel::download(new CourseMember($request), 'export_kursus_member.xlsx');
    }












    // Recap Course
    public function recap_course(Request $request)
    {
        $data = $this->get_etc();

        return view($this->view_path_recap_course . 'index', [
            "data" => $data,
        ]);
    }

    public function json_recap_course(Request $request)
    {
        if ($request->ajax()) {
            $asset = DB::table('view_course_member');
            $asset = $asset->select(
                'view_course_member.*',
                DB::raw('count(*) as total_member')
            )
                ->groupBy('course_id');
            return DataTables::of($asset)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('course_title', 'like', $search_value)
                                ->orWhere('course_code', 'like', $search_value);
                        });
                    }
                })
                ->smart(true)
                ->startsWithSearch()
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function export_recap_course(Request $request)
    {
        return Excel::download(new RecapCourse($request), 'export_rekap_kursus.xlsx');
    }











    //------------------------------
    //---------SELECT2--------------
    //------------------------------
    public function search_member(Request $request)
    {
        $data = User::select('users.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('users.name', 'like', $search_value)
                    ->orWhere('users.email', 'like', $search_value);
            })
            ->where('users.role', User::MEMBER)
            // ->where('users.is_actived', '1')
            ->orderBy('users.name', 'asc')
            ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
            $v->vname = $v->name;
        }
        return json_encode($data);
    }

    public function search_course(Request $request)
    {
        $data = Course::select('courses.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('courses.title', 'like', $search_value)
                    ->orWhere('courses.code', 'like', $search_value);
            })
            ->orderBy('courses.title', 'asc')
            ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
            $v->vname = $v->code;
        }
        return json_encode($data);
    }
}
