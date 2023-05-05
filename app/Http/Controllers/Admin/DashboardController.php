<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfflineCourseAttendance;
use App\Models\OfflineCourseRegistrar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.pages.dashboard.index");
    }

    public function update_dashboard(Request $request)
    {
        $data = array();

        $data['online_course'] = $this->online_course_data($request);
        $data['offline_course'] = $this->offline_course_data($request);

        return $data;
    }

    private function online_course_data($request){

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

        $members = DB::table('view_course_member')
            ->select(
                DB::raw('DATE(created_at) AS group_date'),
                DB::raw('COUNT(*) AS cnt'),
                DB::raw('SUM(course_price) as sum_course_price')
            )
            ->when($request->daterange, function ($query) use ($request) {
                $date = explode(" - ", $request->daterange);
                $start_date = sql_datef($date[0]) . " 00:00:00";
                $end_date = sql_datef($date[1]) . " 23:59:59";
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('created_at', 'ASC')
            ->get();

        $date = explode(" - ", $request->daterange);
        $start_date = sql_datef($date[0]) . " 00:00:00";
        $end_date = sql_datef($date[1]) . " 23:59:59";
        $carbon_start_date = Carbon::parse($start_date);
        $carbon_end_date = Carbon::parse($end_date);

        $course_member_chart_labels = array();
        $member_data = array();
        $member_index = 0;
        $income_data = array();
        $income_index = 0;

        while ($carbon_start_date->lte($carbon_end_date)) {
            $str_date = $carbon_start_date->format('Y-m-d');

            array_push($course_member_chart_labels, $str_date);

            if (count($members) > 0 && $members[$member_index]->group_date == $str_date) {
                array_push($member_data, $members[$member_index]->cnt);
                $member_index += $member_index + 1 == count($members) ? 0 : 1;
            } else {
                array_push($member_data, 0);
            }

            if (count($members) > 0 && $members[$income_index]->group_date == $str_date) {
                array_push($income_data, $members[$income_index]->sum_course_price);
                $income_index += $income_index + 1 == count($members) ? 0 : 1;
            } else {
                array_push($income_data, 0);
            }

            $carbon_start_date->addDays(1);
        }

        return 
            [
                "total_course" => count($total_course),
                "total_member" => $members->sum('cnt'),
                "total_income" => numberf($members->sum('sum_course_price')),
                'course_member_chart_labels' => $course_member_chart_labels,
                'member_data' => $member_data,
                'income_data' => $income_data,
            ];
    }

    private function offline_course_data($request)
    {
        $date = explode(" - ", $request->daterange);
        $start_date = sql_datef($date[0]) . " 00:00:00";
        $end_date = sql_datef($date[1]) . " 23:59:59";

        $registrars = OfflineCourseRegistrar::select(
            DB::raw('DATE(created_at) AS group_date'),
            DB::raw('COUNT(*) AS cnt')
        )
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('created_at', 'ASC')
            ->get();

        $attendances = OfflineCourseAttendance::select(
            DB::raw('DATE(created_at) AS group_date'),
            DB::raw('COUNT(*) AS cnt')
        )
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('created_at', 'ASC')
            ->get();

        $carbon_start_date = Carbon::parse(sql_datef($date[0]));
        $carbon_end_date = Carbon::parse(sql_datef($date[1]));

        $chart_labels = array();
        $attendance_data = array();
        $attendance_index = 0;
        $registrar_data = array();
        $registrar_index = 0;

        while ($carbon_start_date->lte($carbon_end_date)) {
            $str_date = $carbon_start_date->format('Y-m-d');

            array_push($chart_labels, $str_date);

            if (count($attendances) > 0 && $attendances[$attendance_index]->group_date == $str_date) {
                array_push($attendance_data, $attendances[$attendance_index]->cnt);
                $attendance_index += $attendance_index + 1 == count($attendances) ? 0 : 1;
            } else {
                array_push($attendance_data, 0);
            }

            if (count($registrars) > 0 && $registrars[$registrar_index]->group_date == $str_date) {
                array_push($registrar_data, $registrars[$registrar_index]->cnt);
                $registrar_index += $registrar_index + 1 == count($registrars) ? 0 : 1;
            } else {
                array_push($registrar_data, 0);
            }

            $carbon_start_date->addDays(1);
        }

        return
            [
                'chart_labels' => $chart_labels,
                'registrar_sum' => $registrars->sum('cnt'),
                'attendance_sum' => $attendances->sum('cnt'),
                'attendance_data' => $attendance_data,
                'registrar_data' => $registrar_data,
            ];
    }
}
