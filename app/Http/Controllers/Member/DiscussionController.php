<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Discussion;
use App\Models\CourseDiscussion;
use App\Models\CourseDiscussionAnswer;
use App\Models\CourseMemberLesson;
use App\Models\Lesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
    private $ctitle = "Forum Diskusi";
    private $view_path = "member.pages.discussion.";
    private $routes_path;
    private $has_access = "discussion";

    public function __construct()
    {
        $this->routes_path = route('member.discussion.index') . "/";
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
        
        $results_data = $this->get_transaction()->paginate(10);
        
        return view($this->view_path . 'index', [
            "data" => $data,
            "results_data" => $results_data,
        ]);
    }





    //------------------------------
    //----------STORE---------------
    //------------------------------
    public function create(Request $request, $id) 
    {
        $data = $this->get_etc();
        
        $lesson_id = dec($id);

        $course_member_lesson = $this->get_course_member_lesson($lesson_id);

        $results_data = $this->get_lesson($lesson_id);
        if($results_data){

            return view($this->view_path . 'create', compact(
                'data', 
                'results_data',
            ));
        } else return Redirect()->route('member.'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }

    public function store(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                $validator = Validator::make($request->all(), [
                    'lesson_id' => 'required',
                    'title' => 'required',
                    'description' => 'required',
                ]);

                if(!$validator->passes()){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
                //

                $results_data = $this->get_lesson($id);

                if(!$results_data){
                    DB::rollBack();
                    return response()->json(['s' => "Data Kursus tidak ditemukan.", 'st' => 'e']);
                }
    
                $insert_data = new CourseDiscussion();
                $insert_data->lesson_id = $results_data->id;
                $insert_data->member_id = info_user_id();
                $insert_data->title = $request->title;
                $insert_data->description = $request->description;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['p'] = route('member.course_member.show_lesson', enc($results_data->id));
                    $data['s'] = "Data " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }












    //------------------------------
    //----------UPDATE--------------
    //------------------------------
    public function edit(Request $request, $id) 
    {
        $data = $this->get_etc();
        
        $discussion_id = dec($id);

        $results_data = $this->get_discussion($discussion_id);
        if($results_data){

            $discussion_answer_data = $this->get_discussion_answer($results_data->id);

            return view($this->view_path . 'edit', compact(
                'data', 
                'results_data',
                'discussion_answer_data'
            ));
        } else return Redirect()->route('member.'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }

    public function update(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'description' => 'required',
                ]);

                if(!$validator->passes()){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
                //

                $results_data = $this->get_discussion($id);

                if(!$results_data){
                    DB::rollBack();
                    return response()->json(['s' => "Data Kursus tidak ditemukan.", 'st' => 'e']);
                }
    
                $insert_data = CourseDiscussion::find($results_data->id);
                $insert_data->title = $request->title;
                $insert_data->description = $request->description;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }












    //------------------------------
    //----------SHOW----------------
    //------------------------------
    public function show(Request $request, $id) 
    {
        $data = $this->get_etc();
        
        $discussion_id = dec($id);

        $results_data = $this->get_discussion($discussion_id);
        if($results_data){

            $discussion_answer_data = $this->get_discussion_answer($results_data->id);

            return view($this->view_path . 'show', compact(
                'data', 
                'results_data',
                'discussion_answer_data',
            ));
        } else return Redirect()->route('member.'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }









    //------------------------------
    //-----------DELETE-------------
    //------------------------------
    public function destroy(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);
        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $discussion_id = dec($id);

                $discussion = $this->get_discussion($discussion_id)->first();
                if(!$discussion){
                    DB::rollBack();
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $results_data = CourseDiscussion::find($discussion->id);
                $lesson_id = $results_data->lesson_id;

                if($results_data->delete()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['p'] = route('member.course_member.show_lesson', enc($lesson_id));
                    $data['s'] =  $this->ctitle . " berhasil dihapus.";
                }
                else{
                    DB::rollBack();
                    $data['s'] =  $this->ctitle . " gagal dihapus.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] =  $this->ctitle . " gagal dihapus.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }












    //------------------------------
    //--------STORE ANSWER----------
    //------------------------------
    public function store_answer(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                $validator = Validator::make($request->all(), [
                    'answer' => 'required',
                ]);

                if(!$validator->passes()){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
                //

                $results_data = $this->get_discussion($id);

                if(!$results_data){
                    DB::rollBack();
                    return response()->json(['s' => "Data ". $this->ctitle ." tidak ditemukan.", 'st' => 'e']);
                }
    
                $insert_data = new CourseDiscussionAnswer();
                $insert_data->discussion_id = $results_data->id;
                $insert_data->answer = $request->answer;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }










    //------------------------------
    //-----------DATA---------------
    //------------------------------
    public function get_transaction()
    {
        $results_data = CourseDiscussion::select(
            'course_discussions.*', 
            'u.name as member_name'
            )
            ->leftJoin('users as u', 'u.id', '=', 'course_discussions.member_id')
            ->where('course_discussions.member_id', info_user_id());
        return $results_data;
    }

    public function get_lesson($id)
    {
        $results_data = Lesson::select(
            'lessons.*',
            'c.id as course_id',
            'c.url_image as course_url_image',
            'c.title as course_title',
            'cs.title as course_section_title',
            'l.name as level_name',
            )
            ->rightJoin('course_member_lessons as cml', 'cml.lesson_id', '=', 'lessons.id')
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'lessons.course_section_id')
            ->leftJoin('courses as c', 'c.id', '=', 'cs.course_id')
            ->leftJoin('levels as l', 'l.id', '=', 'c.level_id')
            ->where('cs.is_actived', '1')
            ->where('lessons.is_actived', '1')
            ->where('c.is_actived', '1')
            ->where('lessons.id', $id)
            ->where('cml.member_id', info_user_id())
            ->whereNull('cml.deleted_at')
            ->first();
        return $results_data;
    }

    public function get_course_member_lesson($id){
        $results_data = CourseMemberLesson::
            select(
                'course_member_lessons.*',
            )
            ->where('course_member_lessons.lesson_id', $id)
            ->where('course_member_lessons.member_id', info_user_id())
            ->whereNull('course_member_lessons.deleted_at')
            ->first();
        return $results_data;
    }

    public function get_discussion($id)
    {
        $results_data = CourseDiscussion::select(
            'course_discussions.*',
            'c.id as course_id',
            'c.url_image as course_url_image',
            'c.title as course_title',
            'cs.title as course_section_title',
            'l.name as level_name',
            'u.name as member_name',
            'le.title as lesson_title',
            )
            ->leftJoin('lessons as le', 'le.id', '=', 'course_discussions.lesson_id')
            ->rightJoin('course_member_lessons as cml', 'cml.lesson_id', '=', 'le.id')
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'le.course_section_id')
            ->leftJoin('courses as c', 'c.id', '=', 'cs.course_id')
            ->leftJoin('levels as l', 'l.id', '=', 'c.level_id')
            ->leftJoin('users as u', 'u.id', '=', 'course_discussions.created_by')
            ->where('course_discussions.id', $id)
            ->whereNull('cml.deleted_at')
            ->first();
        return $results_data;
    }

    public function get_discussion_answer($id){
        $results_data = CourseDiscussionAnswer::select(
            'course_discussion_answers.*',
            'u.name as member_name'
            )
            ->leftJoin('users as u', 'u.id', '=', 'course_discussion_answers.created_by')
            ->where('course_discussion_answers.discussion_id', $id)
            ->get();

        return $results_data;
    }









    //------------------------------
    //---------SELECT2--------------
    //------------------------------
    public function search_lesson(Request $request, $id){

        $results_data = Lesson::find(dec($id));

        $data = Lesson::
                    where(function ($query) use ($request) {
                        $search_value = '%' . $request->search . '%';
                        $query->where('lessons.title', 'like', $search_value);
                    })
                    ->where('course_section_id', $results_data->course_section_id)
                    ->where('lessons.is_actived', '1')
                    ->orderBy('lessons.position', 'asc')
                    ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
        }
        return json_encode($data);
    }
}
