<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\CourseFavorite;
use App\Models\CourseLearnDescription;
use App\Models\CourseReview;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\Level;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    private $ctitle = "Kursus";
    private $view_path = "member.pages.course.";
    private $routes_path;
    private $has_access = "course";

    public function __construct()
    {
        $this->routes_path = route('course.index') . "/";
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

        $results_data = Course::select('courses.*', 'l.name as level_name')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            // ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
            ->paginate(10);

        $category_data = CategoryCourse::where('is_actived', '1')->get();
        $level_data = Level::where('is_actived', '1')->get();

        return view($this->view_path . 'index', [
            "data" => $data,
            "results_data" => $results_data,
            "category_data" => $category_data,
            "level_data" => $level_data,
        ]);
    }

    public function search(Request $request)
    {
        $data = $this->get_etc();

        $query = Course::select('courses.*', 'l.name as level_name')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id');


        if ($request->input('text_filter')) {
            $search_text = '%' . $request->input('text_filter') . '%';
            $query->where('courses.title', 'LIKE', $search_text);
        } else {
            $category_filter = $request->input('category_filter');
            if ($category_filter) {
                if (!in_array('semua', $category_filter)) {
                    $query->whereHas('categories', function (Builder $q) use ($category_filter) {
                        $q->whereHas('category_course', function (Builder $q) use ($category_filter) {
                            $q->whereIn('name', $category_filter);
                        });
                    });
                }
            }

            $level_filter = $request->input('level_filter');
            if ($level_filter) {
                if (!in_array('semua', $level_filter)) {
                    $query->whereIn('l.name', $level_filter);
                }
            }
        }

        $results_data = $query->paginate(12);

        $category_data = CategoryCourse::where('is_actived', '1')->get();
        $level_data = Level::where('is_actived', '1')->get();

        return view($this->view_path . 'search', [
            "data" => $data,
            "results_data" => $results_data,
            "category_data" => $category_data,
            "level_data" => $level_data,
        ]);
    }










    public function show(Request $request, $id)
    {
        $data = $this->get_etc();

        $id = dec($id);
        $results_data = $this->get_transaction($id)->first();

        // return $results_data;
        if ($results_data) {

            $section_data = $this->get_section($id);
            $learn_description_data = $this->get_learn_description($id);

            $lesson_course_data = $this->get_lesson_by_course($id);

            $popular_course_data = Course::course_popular();

            return view($this->view_path . 'show', compact('data', 'results_data', 'section_data', 'learn_description_data', 'popular_course_data', 'lesson_course_data'));
        } else return Redirect()->route($this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }









    //------------------------------
    //-------PREVIEW LESSON---------
    //------------------------------
    public function preview_lesson(Request $request, $id)
    {
        $data = $this->get_etc();

        $id = dec($id);
        $results_data = $this->get_lesson($id);

        if ($results_data) {

            if (!$results_data->can_preview) {
                return Redirect()->route($this->has_access . '.show', enc($results_data->course_id))->with("error", "Data Pelajaran tidak ditemukan.");
            }

            $lesson_file = $this->get_lesson_file($results_data->id);

            return view($this->view_path . 'preview_lesson', compact('data', 'results_data', 'lesson_file'));
        } else return Redirect()->route($this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }










    //------------------------------
    //---------FAVORITE-------------
    //------------------------------
    public function store_favorite(Request $request)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if (request()->ajax()) {
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';
                $id = dec($request->course_id);

                $results_data = $this->get_transaction($id)->first();
                if (!$results_data) {
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $member = User::where('role', User::MEMBER)->where('id', info_user_id())->first();
                if (!$member) {
                    return response()->json(['s' => "Data Member tidak ditemukan.", 'st' => 'e']);
                }

                $favorite = CourseFavorite::where('course_id', $id)->where('member_id', $member->id)->first();
                if (!$favorite) {
                    $insert_data = new CourseFavorite();
                    $insert_data->course_id = $results_data->id;
                    $insert_data->member_id = $member->id;

                    if ($insert_data->save()) {
                        DB::commit();
                        $data['st'] = 's';
                        $data['d'] = 1;
                        $data['s'] = "Anda menyimpan " . $this->ctitle . " ini sebagai favorit anda.";
                    } else {
                        DB::rollBack();
                        $data['s'] = "Data Favorite " . $this->ctitle . " gagal disimpan.";
                    }
                } else {
                    if ($favorite->delete()) {
                        DB::commit();
                        $data['st'] = 's';
                        $data['d'] = 0;
                        $data['s'] = "Anda menghapus " . $this->ctitle . " ini dari daftar favorite anda.";
                    } else {
                        DB::rollBack();
                        $data['s'] = "Data Favorite " . $this->ctitle . " gagal disimpan.";
                    }
                }
            } catch (Exception $e) {

                DB::rollBack();
                $data['s'] = "Data Favorite " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //---------TRAILER--------------
    //------------------------------
    public function show_trailer(Request $request)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($request->course_id);

        $results_data = $this->get_transaction($id)->first();

        if ($results_data) {

            $data['st'] = 's';
            $data['url_video'] = $results_data->url_video;
            return response()->json(['st' => $data['st'], 'url_video' => $data['url_video']]);
        } else return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
    }










    //------------------------------
    //----------DATA----------------
    //------------------------------
    public function get_transaction($id)
    {
        $results_data = Course::select(
            'courses.*',
            'l.name as level_name',
            // 'cc.name as categories_name'
        )
            ->with('product', 'product.cart')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            // ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
            ->where('courses.id', $id);
        return $results_data;
    }

    public function get_section($id)
    {
        $results_data = CourseSection::select(
            'course_sections.*'
        )
            ->leftJoin('courses as c', 'c.id', '=', 'course_sections.course_id')
            ->where('course_sections.course_id', $id)
            ->where('course_sections.is_actived', '1')
            ->orderBy('course_sections.position', 'asc')
            ->get();
        return $results_data;
    }

    public function get_learn_description($id)
    {
        $results_data = CourseLearnDescription::select(
            'course_learn_descriptions.*'
        )
            ->leftJoin('courses as c', 'c.id', '=', 'course_learn_descriptions.course_id')
            ->where('course_learn_descriptions.course_id', $id)
            ->get();
        return $results_data;
    }

    public function get_lesson_by_course($id)
    {
        $results_data = Lesson::select(
            'lessons.*'
        )
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'lessons.course_section_id')
            ->leftJoin('courses as c', 'c.id', '=', 'cs.course_id')
            ->where('cs.is_actived', '1')
            ->where('lessons.is_actived', '1')
            ->where('c.id', $id)
            ->get();
        return $results_data;
    }

    public function get_lesson($id)
    {
        $results_data = Lesson::select(
            'lessons.*',
            'c.id as course_id',
            'c.url_image as course_url_image',
            'c.title as course_title',
            'l.name as level_name'
        )
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'lessons.course_section_id')
            ->leftJoin('courses as c', 'c.id', '=', 'cs.course_id')
            ->leftJoin('levels as l', 'l.id', '=', 'c.level_id')
            ->where('cs.is_actived', '1')
            ->where('lessons.is_actived', '1')
            ->where('c.is_actived', '1')
            ->where('lessons.id', $id)
            ->first();
        return $results_data;
    }

    public function get_lesson_file($id)
    {
        $results_data = LessonFile::select(
                'lesson_files.*',
            )
            ->where('lesson_files.lesson_id', $id)
            ->whereNull('lesson_files.deleted_at')
            ->get();
        return $results_data;
    }
}
