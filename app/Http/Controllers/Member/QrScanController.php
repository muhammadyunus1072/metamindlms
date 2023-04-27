<?php

namespace App\Http\Controllers\Member;

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
        $decOfflineCourseId = Crypt::decryptString($request->id);

        $registrar = OfflineCourseRegistrar::where('user_id', '=', $authUser->id)
            ->where('offline_course_id', '=', $decOfflineCourseId)
            ->first();
        if (empty($registrar)) {
            return view('member.pages.qr_scan.attend_error', ['error' => 'Pendaftar Tidak Ditemukan']);
        }

        $checkAttendance = OfflineCourseAttendance::where('offline_course_id', '=', $decOfflineCourseId)
            ->where('user_id', '=', $registrar->user_id)
            ->first();
        if (!empty($checkAttendance)) {
            return view('member.pages.qr_scan.attend_error', ['error' => 'Peserta Sudah Terdapat Dalam Daftar Kehadiran']);
        }

        OfflineCourseAttendance::create([
            'offline_course_registrar_id' => $registrar->id,
        ]);
        
        return view('member.pages.qr_scan.attend_success', ['success' => 'Pendataan Kehadiran Berhasil']);
    }
}
