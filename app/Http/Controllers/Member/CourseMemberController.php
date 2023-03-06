<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLearnDescription;
use App\Models\CourseMemberLesson;
use App\Models\CourseReview;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Level;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseMemberController extends Controller
{
    private $ctitle = "Kursus";
    private $view_path = "member.pages.course_member.";
    private $routes_path;
    private $has_access = "course_member";

    public function __construct()
    {
        $this->routes_path = route('member.course_member.index') . "/";
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
        
        $results_data = $this->search_course($request)->get();

        $category_data = CategoryCourse::where('is_actived', '1')->get();
        $level_data = Level::where('is_actived', '1')->get();
        
        return view($this->view_path . 'index', [
            "data" => $data,
            "results_data" => $results_data,
            "category_data" => $category_data,
            "level_data" => $level_data,
        ]);
    }









    //------------------------------
    //----------SHOW----------------
    //------------------------------
    public function show(Request $request, $id) 
    {
        $data = $this->get_etc();

        $id = dec($id);
        $results_data = $this->get_transaction($id)->first();

        if($results_data){

            $category_data = $this->get_category_course($id);
            $section_data = $this->get_section($id);
            $learn_description_data = $this->get_learn_description($id);

            $review_data = $this->get_review($id);

            $popular_course_data = Course::course_popular();

            return view($this->view_path . 'show', compact(
                'data', 
                'results_data', 
                'popular_course_data', 
                'category_data', 
                'section_data', 
                'learn_description_data',
                'review_data',
            ));
        } else return Redirect()->route($this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }









    //------------------------------
    //-------STORE REVIEW-----------
    //------------------------------
    public function store_review(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);
        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $course_id = dec($id);

                //VALIDATION
                $validator = Validator::make($request->all(), [
                    'rating' => 'required',
                    'comment' => 'required',
                ]);

                if(!$validator->passes()){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
                //

                $results_data = $this->get_transaction($course_id)->first();
                if(!$results_data){
                    DB::rollBack();
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $insert_data = new CourseReview();
                $insert_data->course_id = $results_data->id;
                $insert_data->member_id = info_user_id();
                $insert_data->rating = $request->rating;
                $insert_data->comment = $request->comment;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data Review " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Review " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Review " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }











    //------------------------------
    //-------SHOW LESSON------------
    //------------------------------
    public function show_lesson(Request $request, $id) 
    {
        $data = $this->get_etc();

        $lesson_id = dec($id);
        $results_data = $this->get_lesson($lesson_id)->first();

        if($results_data){

            return view($this->view_path . 'show_lesson', compact(
                'data', 
                'results_data',
            ));
        } else return Redirect()->route('member.'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }









    //------------------------------
    //----------DATA----------------
    //------------------------------
    public function get_transaction($id)
    {
        $results_data = Course::select(
            'courses.*', 
            'l.name as level_name',
            )
            ->rightJoin('course_members as cm', 'cm.course_id', '=', 'courses.id')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->where('cm.member_id', info_user_id())
            ->whereNull('cm.deleted_at')
            ->where('courses.id', $id);
        return $results_data;
    }

    public function search_course($request){
        $query = Course::select(
            'courses.*', 
            'l.name as level_name'
            )
            ->rightJoin('course_members as cm', 'cm.course_id', '=', 'courses.id')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->where('cm.member_id', info_user_id())
            ->whereNull('cm.deleted_at')
            ;


        if($request->input('text_filter')){
            $search_text = '%'.$request->input('text_filter').'%';
            $query->where('courses.title', 'LIKE', $search_text);
        }
        else{
            $category_filter = $request->input('category_filter');
            if($category_filter){
                if(!in_array('semua', $category_filter)){
                    $query->whereHas('categories', function(Builder $q) use($category_filter){
                        $q->whereHas('category_course', function(Builder $q) use($category_filter){
                            $q->whereIn('name', $category_filter);
                        });
                    });
                }
            }
    
            $level_filter = $request->input('level_filter');
            if($level_filter){
                if(!in_array('semua', $level_filter)){
                    $query->whereIn('l.name', $level_filter);
                }
            }
        }

        return $query;
    }

    public function get_category_course($id)
    {
        $results_data = CourseCategory::select(
            'course_categories.*',
            'cc.name as category_name'
            )
            ->leftJoin('category_courses as cc', 'cc.id', '=', 'course_categories.category_course_id')
            ->where('course_categories.course_id', $id)
            ->orderBy('cc.name', 'asc')
            ->get();
        return $results_data;
    }

    public function get_section($id)
    {
        $results_data = CourseSection::select('course_sections.*')
            ->where('course_sections.course_id', $id)
            ->orderBy('course_sections.position', 'asc')
            ->get();
        return $results_data;
    }

    public function get_learn_description($id)
    {
        $results_data = CourseLearnDescription::
            select('course_learn_descriptions.*')
            ->where('course_learn_descriptions.course_id', $id)
            ->get();
        return $results_data;
    }

    public function get_review($id)
    {
        $results_data = CourseReview::
            select(
                'course_reviews.*',
                'u.name as member_name',
            )
            ->leftJoin('users as u', 'u.id', '=', 'course_reviews.member_id')
            ->where('course_reviews.course_id', $id)
            ->where('course_reviews.member_id', info_user_id())
            ->first();
        return $results_data;
    }

    public function get_lesson($id)
    {
        $results_data = Lesson::
            select(
                'lessons.*',
            )
            ->rightJoin('course_member_lessons as cml', 'cml.lesson_id', '=', 'lessons.id')
            ->where('lessons.id', $id)
            ->where('cml.member_id', info_user_id())
            ->whereNull('cml.deleted_at')
            ->first();
        return $results_data;
    }
}
