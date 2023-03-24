<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    private $ctitle = "Kursus";
    private $view_path = "member.pages.favorite.";
    private $routes_path;
    private $has_access = "favorite";

    public function __construct()
    {
        $this->routes_path = route('member.favorite.index') . "/";
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
    //----------DATA----------------
    //------------------------------
    public function search_course($request){
        $query = Course::select(
            'courses.*', 
            'l.name as level_name'
            )
            ->rightJoin('course_favorites as cf', 'cf.course_id', '=', 'courses.id')
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->where('cf.member_id', info_user_id())
            ->whereNull('cf.deleted_at')
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
}
