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

    public function destroy(Request $request)
    {
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
