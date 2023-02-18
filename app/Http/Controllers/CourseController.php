<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLearnDescription;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $ctitle = "Kursus";
    private $view_path = "pages.course.";
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
                                ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
                                ->paginate(10);

        $category_data = CourseCategory::where('is_actived', '1')->get();
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
                                ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
                                ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id');


        if($request->input('text_filter')){
            $search_text = '%'.$request->input('text_filter').'%';
            $query->where('courses.title', 'LIKE', $search_text);
        }
        else{
            $category_filter = $request->input('category_filter');
            if($category_filter){
                if(!in_array('semua', $category_filter)){
                    $query->whereIn('cc.name', $category_filter);
                }
            }
    
            $level_filter = $request->input('level_filter');
            if($level_filter){
                if(!in_array('semua', $level_filter)){
                    $query->whereIn('l.name', $level_filter);
                }
            }
        }
        
        $results_data = $query->get();

        $category_data = CourseCategory::where('is_actived', '1')->get();
        $level_data = Level::where('is_actived', '1')->get();
        
        return view($this->view_path . 'search', [
            "data" => $data,
            "results_data" => $results_data,
            "category_data" => $category_data,
            "level_data" => $level_data,
        ]);
    }

    // public function pagination_course_data(Request $request)
    // {
    //     // $authUser = $request->user();

    //     // $request->date_start = $request->date_start . " 00:00:00";
    //     // $request->date_end = $request->date_end . " 23:59:59";

    //     // // Build Query
    //     // if ($request->student_id == 'all') {
    //     //     $studentIds = $authUser->students()->select('students.id')->get()->pluck('id');
    //     // } else {
    //     //     $studentIds = array(Student::findByUuid($request->student_id)->id);
    //     // }

    //     $results_data = Course::select('courses.*', 'l.name as level_name')
    //                             ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
    //                             ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id');

    //     $count = clone $results_data;

    //     // Get Data
    //     $skip = ($request->page - 1) * $request->item_each_page;
    //     $length = $request->page * $request->item_each_page;
    //     $result = $results_data->skip($skip)->take($length)->get();

    //     $recordsTotal = $count->count();

    //     // Reconstruct Data
    //     $data = array();
    //     foreach ($result as $v) {
    //         array_push($data, [
    //             "url_image" => asset('/assets/images/paths/mailchimp_430x168.png'),
    //             "title" => $v->title,
    //             "level_name" => $v->level_name,
    //             "description" => $v->description,
    //             "learn_description" => $v->learn_description,
    //         ]);
    //     }

    //     return [
    //         'recordsTotal' => $recordsTotal,
    //         'data' => $data,
    //     ];
    // }





    //------------------------------
    //----------DATA----------------
    //------------------------------
    public function get_transaction($id)
    {
        $results_data = Course::select(
            'courses.*', 
            'l.name as level_name',
            'cc.name as categories_name'
            )
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
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






    public function show(Request $request, $id) 
    {
        $data = $this->get_etc();

        $id = dec($id);
        $results_data = $this->get_transaction($id)->first();

        if($results_data){

            $section_data = $this->get_section($id);
            $learn_description_data = $this->get_learn_description($id);

            $lesson_course_data = $this->get_lesson_by_course($id);

            $popular_course_data = Course::select('courses.*', 'l.name as level_name')
                                ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
                                ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
                                ->paginate(10);

            return view($this->view_path . 'show', compact('data', 'results_data', 'section_data', 'learn_description_data', 'popular_course_data', 'lesson_course_data'));
        } else return Redirect()->route($this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }






    
}
