<?php

namespace App\Http\Controllers\Admin;

use App\Models\OfflineCourseRegistrar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class OfflineCourseRegistrarController extends Controller
{
    public function select2(Request $request)
    {
        $decId = Crypt::decryptString($request->offline_course_id);

        $data = OfflineCourseRegistrar::select('id', 'user_name', 'user_email')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('user_name', 'like', $search_value)
                    ->orWhere('user_email', 'like', $search_value);
            })
            ->where('offline_course_id', '=', $decId)
            ->whereDoesntHave('offlineCourseAttendance')
            ->orderBy('user_name', 'asc')
            ->get();

        $res = [];
        foreach ($data as $item) {
            array_push($res, ['id' => Crypt::encryptString($item->id), 'text' => $item->user_name . " - " . $item->user_email]);
        }

        return $res;
    }
}
