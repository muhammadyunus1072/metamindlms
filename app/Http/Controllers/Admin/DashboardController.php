<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.pages.dashboard.index");
    }

    public function update_dashboard(Request $request){
        
        $data = array();

        $total_course = DB::table('view_course_member')
            ->select(
                'view_course_member.*'
            )
            ->when($request->daterange, function ($query) use ($request) {
                $date = explode(" - ", $request->daterange);
                $start_date = sql_datef($date[0]) . " 00:00:00";
                $end_date = sql_datef($date[1]) . " 23:59:59";
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->groupBy('course_id')
            ->get();

        $total_member = DB::table('view_course_member')
            ->select(
                'view_course_member.*'
            )
            ->when($request->daterange, function ($query) use ($request) {
                $date = explode(" - ", $request->daterange);
                $start_date = sql_datef($date[0]) . " 00:00:00";
                $end_date = sql_datef($date[1]) . " 23:59:59";
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->groupBy('member_id')
            ->get();

        $total_income = DB::table('view_course_member')
            ->select(
                'view_course_member.*'
            )
            ->when($request->daterange, function ($query) use ($request) {
                $date = explode(" - ", $request->daterange);
                $start_date = sql_datef($date[0]) . " 00:00:00";
                $end_date = sql_datef($date[1]) . " 23:59:59";
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->sum('course_price');

        $data["total_course"] = count($total_course);
        $data["total_member"] = count($total_member);
        $data["total_income"] = numberf($total_income);

        return $data;
    }
}
