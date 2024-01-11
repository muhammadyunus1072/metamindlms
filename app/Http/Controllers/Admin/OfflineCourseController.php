<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptionHelper;
use App\Http\Controllers\Controller;
use App\Models\OfflineCourse;
use App\Models\CategoryCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OfflineCourseController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.master.offline_course.index');
    }

    public function create(Request $request)
    {
        return view('admin.pages.master.offline_course.detail', ['offlineCourse' => null]);
    }

    public function edit(Request $request)
    {
        $decId = Crypt::decryptString($request->id);
        $offlineCourse = OfflineCourse::find($decId);

        return view('admin.pages.master.offline_course.detail', ['offlineCourse' => $offlineCourse]);
    }

    public function show(Request $request)
    {
        $decId = Crypt::decryptString($request->id);
        $offlineCourse = OfflineCourse::find($decId);

        return view('admin.pages.master.offline_course.show', ['offlineCourse' => $offlineCourse]);
    }

    public function showQr(Request $request)
    {
        $decId = Crypt::decryptString($request->id);

        $offlineCourse = OfflineCourse::find($decId);
        $offlineCourse->url = route('member.qr_scan.show', EncryptionHelper::encrypt($decId));

        return view('admin.pages.master.offline_course.show_qr', ['offlineCourse' => $offlineCourse]);
    }

    public function select2Category(Request $request)
    {
        $data = CategoryCourse::select('id', 'name')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('category_courses.name', 'like', $search_value);
            })
            ->where('is_actived', '=', '1')
            ->orderBy('name', 'asc')
            ->get();

        $res = [];
        foreach ($data as $item) {
            array_push($res, ['id' => Crypt::encryptString($item->id), 'text' => $item->name]);
        }

        return $res;
    }

    public function searchOfflineCourse(Request $request){
        $data = OfflineCourse::select(
            'id',
            'title as text'
        )
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', "%$request->search%");
            });
        })
        ->orderBy('title')
        ->limit(100)
        ->get()
        ->toArray();

        return json_encode($data);
    }

    // Select 2 Offline Course
    public function search(Request $request)
    {
        $data = OfflineCourse::select('id', 'title')
            ->where('title', 'LIKE', '%' . $request->search . '%')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        foreach ($data as $index => $item) {
            $data[$index]['id'] = Crypt::encrypt($item['id']);
        }

        return json_encode($data);
    }
}
