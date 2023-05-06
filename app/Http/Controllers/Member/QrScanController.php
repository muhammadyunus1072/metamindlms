<?php

namespace App\Http\Controllers\Member;

use App\Helpers\EncryptionHelper;
use App\Http\Controllers\Controller;
use App\Models\OfflineCourseAttendance;
use App\Models\OfflineCourseRegistrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QrScanController extends Controller
{
    public function index()
    {
        return view('member.pages.qr_scan.index');
    }

    public function show(Request $request)
    {
        $authUser = Auth::user();
        $decOfflineCourseId = EncryptionHelper::decrypt($request->id);

        $registrar = OfflineCourseRegistrar::where('user_id', '=', $authUser->id)
            ->where('offline_course_id', '=', $decOfflineCourseId)
            ->first();
        if (empty($registrar)) {
            return view('member.pages.qr_scan.attend_error', ['error' => 'Pendaftar Tidak Ditemukan']);
        }

        $checkAttendance = OfflineCourseAttendance::where('offline_course_id', '=', $decOfflineCourseId)
            ->where('user_id', '=', $registrar->user_id)
            ->first();

        if (empty($checkAttendance)) {
            OfflineCourseAttendance::create([
                'offline_course_registrar_id' => $registrar->id,
            ]);
        }

        return view('member.pages.qr_scan.attend_success', [
            'success' => 'Pendataan Kehadiran Berhasil',
            'url_show' => route('offline_course.show', Crypt::encrypt($decOfflineCourseId)),
        ]);
    }
}
