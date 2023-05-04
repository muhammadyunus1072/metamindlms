<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLearnDescription;
use App\Models\CourseMember;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\Level;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    private $ctitle = "Kursus";
    private $view_path = "admin.pages.master.course.";
    private $routes_path;
    private $has_access = "course";

    public function __construct()
    {
        $this->routes_path = route('admin.course.index') . "/";
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

    // Halaman utama
    public function index(Request $request) 
    {
        $data = $this->get_etc();
        return view($this->view_path . 'index', [
            "data" => $data,
        ]);
    }

    public function json(Request $request){
        // Saat request ajax datatable
        if ($request->ajax()) {
            $asset = new Course;
            $asset = $asset->select(
                'courses.*', 
                'l.name as level_name',
                'a.name as admins_name',
                )
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->leftJoin('users as a', 'a.id', '=', 'courses.created_by')
            ->whereNull("courses.deleted_at");
            return DataTables::of($asset)
                ->addIndexColumn()
                ->filter(function ($query) use ($request){
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('courses.code', 'like', $search_value)
                                ->orWhere('courses.title', 'like', $search_value)
                                ->orWhere('a.name', 'like', $search_value);
                        });
                    }
                })
                ->addColumn('vname', function ($row) {
                    $view = '<b>' . $row->code . '</b>' . ' <br> ' . $row->title;
                    return $view;
                })
                ->addColumn('vlevel', function ($row) {
                    $view = '<b>Level : </b>' . $row->level_name;
                    return $view;
                })
                ->addColumn('vprice', function ($row) {
                    $view = numberf($row->price);
                    return $view;
                })
                ->addColumn('vstatus_text', function ($row) {
                    if ($row->is_actived)  return 'menonaktifkan';
                    else return 'mengaktifkan';
                })
                ->addColumn('vstatus', function ($row) {
                    if ($row->is_actived) {
                        return '<span class="badge badge-primary">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('created_date', function ($row) {
                    $view = timestampf($row->created_at);
                    return $view;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="btn-group">
                        <button type="button"
                            class="btn btn-primary btn-sm dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">Aksi <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                    ';

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '
                        <a class="dropdown-item" name="btn_m" id="btn_m"><i class="fas fa-user mr-2"></i> Member</a>';
                    // }
                        
                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" name="btn_u" id="btn_u"><i class="fas fa-edit mr-2"></i> Ubah</a>';
                    // }

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" name="btn_ac" id="btn_ac"><i class="fas fa-lock mr-2"></i> Aktifkan</a>';
                    // }

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" name="btn_dl" id="btn_dl"><i class="fas fa-trash mr-2"></i> Hapus</a>';
                    // }
                    
                    $btn .= '
                        </div>
                    </div>
                    ';

                    return $btn;
                })
                ->addColumn('m', function ($row) {
                    return $this->routes_path . 'member_course/' . enc($row->id);
                })
                ->addColumn('up', function ($row) {
                    return $this->routes_path . 'edit/' . enc($row->id);
                })
                ->addColumn('ac', function ($row) {
                    return $this->routes_path . 'active/' . enc($row->id);
                })
                ->addColumn('dl', function ($row) {
                    return $this->routes_path . 'delete/' . enc($row->id);
                })
                ->smart(true)
                ->startsWithSearch()
                ->rawColumns(['vname', 'vlevel', 'vprice', 'vstatus', 'created_date', 'action'])
                ->toJson();
        }
    }




    //------------------------------
    //---------STORE----------------
    //------------------------------
    public function create()
    {
        // if (!has_access($this->has_access, "created")) return abort(403);

        $data = $this->get_etc();

        return view($this->view_path . 'create', compact('data'));
    }

    public function store(Request $request)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';

                //VALIDATION
                if(!$request->title || !$request->url_video || !$request->category_id || !$request->level_id || !$request->price){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
    
                $level = Level::find(dec($request->level_id));

                if(!$level){
                    DB::rollBack();
                    return response()->json(['s' => "Level kursus tidak ditemukan.", 'st' => 'e']);
                }
                
                $insert_data = new Course();

                //Save Data
                if($request->file()){
                    $validator = Validator::make($request->all(), [
                        'url_image' => 'mimes:jpg,jpeg,png|file|max:2048',
                    ]);

                    if($validator->passes()){
                        $name_gen = hexdec(uniqid());
                        $image_ext = strtolower($request->url_image->getClientOriginalExtension());
                        $image_name = 'course_'.date('Y_m_d').'_'.$name_gen.'.'.$image_ext;
                        $request->url_image->move(FileHelper::COURSE_SAVE_LOCATION, $image_name);
                        
                        $insert_data->url_image = $image_name;
                    }
                    else{
                        DB::rollBack();
                        return response()->json(['s' => "Format foto tidak sesuai, harap periksa kembali format foto.", 'st' => 'e']);
                    }
                }

                $insert_data->title = $request->title;
                $insert_data->about = $request->about;
                $insert_data->description = $request->description;
                $insert_data->url_video = $request->url_video;
                $insert_data->level_id = $level->id;
                $insert_data->price = $request->price;

                if($insert_data->save()){
                    //Save Data
                    if($request->category_id){
                        $validator = Validator::make($request->all(), [
                            'category_id' => 'array',
                        ]);
    
                        if($validator->passes()){
                            foreach($request->category_id as $k => $v){
                                $c_category = CategoryCourse::where('code', $v)->where('is_actived', '1')->first();

                                if(!$c_category){
                                    DB::rollBack();
                                    return response()->json(['s' => "Data Kategori yang anda masukkan tidak ditemukan, Harap cek kembali data yang dimasukkan.", 'st' => 'e']);
                                }

                                $category = new CourseCategory();
                                $category->course_id = $insert_data->id;
                                $category->category_course_id = $c_category->id;
                                $category->save();
                            }
                        }
                        else{
                            DB::rollBack();
                            return response()->json(['s' => "Data Kategori yang anda masukkan tidak sesuai, Harap cek kembali data yang dimasukkan.", 'st' => 'e']);
                        }
                    }

                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data " . $this->ctitle . " berhasil disimpan.";
                    $data['p'] = $this->routes_path. 'edit/' .enc($insert_data->id);
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
    //---------UPDATE---------------
    //------------------------------
    public function edit($id, Request $request)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_transaction($id)->first();
        
        if ($results_data) {

            $section_data = $this->get_transaction_section($id);
            $learn_description_data = $this->get_transaction_learn_description($id);
            $category_data = $this->get_transaction_category($id);

            return view($this->view_path . 'edit', compact('data', 'results_data', 'section_data', 'learn_description_data', 'category_data'));
        } else return Redirect()->route('admin.'. $this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
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
                if(!$request->title || !$request->url_video || !$request->category_id || !$request->level_id || !$request->price){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }
    
                $level = Level::find(dec($request->level_id));

                if(!$level){
                    DB::rollBack();
                    return response()->json(['s' => "Level kursus tidak ditemukan.", 'st' => 'e']);
                }

                $results_data = Course::find($id);

                if($results_data){

                    //Save Data
                    if($request->file()){
                        $validator = Validator::make($request->all(), [
                            'url_image' => 'mimes:jpg,jpeg,png|file|max:2048',
                        ]);
    
                        if($validator->passes()){
                            $name_gen = hexdec(uniqid());
                            $image_ext = strtolower($request->url_image->getClientOriginalExtension());
                            $image_name = 'course_'.date('Y_m_d').'_'.$name_gen.'.'.$image_ext;
                            $request->url_image->move(FileHelper::COURSE_SAVE_LOCATION, $image_name);
                            
                            $results_data->url_image = $image_name;
                        }
                        else{
                            DB::rollBack();
                            return response()->json(['s' => "Format foto tidak sesuai, harap periksa kembali format foto.", 'st' => 'e']);
                        }
                    }
    
                    $results_data->title = $request->title;
                    $results_data->about = $request->about;
                    $results_data->description = $request->description;
                    $results_data->url_video = $request->url_video;
                    $results_data->level_id = $level->id;
                    $results_data->price = $request->price;

                    if($results_data->save()){

                        //Save Data
                        if($request->category_id){
                            $validator = Validator::make($request->all(), [
                                'category_id' => 'array',
                            ]);
        
                            if($validator->passes()){
                                CourseCategory::where('course_id', $results_data->id)->delete();

                                foreach($request->category_id as $k => $v){
                                    $c_category = CategoryCourse::where('code', $v)->where('is_actived', '1')->first();

                                    if(!$c_category){
                                        DB::rollBack();
                                        return response()->json(['s' => "Data Kategori yang anda masukkan tidak ditemukan, Harap cek kembali data yang dimasukkan.", 'st' => 'e']);
                                    }

                                    $category = new CourseCategory();
                                    $category->course_id = $results_data->id;
                                    $category->category_course_id = $c_category->id;
                                    $category->save();
                                }
                            }
                            else{
                                DB::rollBack();
                                return response()->json(['s' => "Data Kategori yang anda masukkan tidak sesuai, Harap cek kembali data yang dimasukkan.", 'st' => 'e']);
                            }
                        }    
    
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data " . $this->ctitle . " berhasil diperbarui.";
                        $data['p'] = $this->routes_path. 'edit/' .enc($results_data->id);
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data " . $this->ctitle . " gagal diperbarui.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal diperbarui.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }







    //------------------------------
    //---------DELETE---------------
    //------------------------------
    public function destroy($id)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';

                $id = dec($id);
                $results_data = Course::find($id);
                

                if($results_data){

                    if($results_data->delete()){
                        DB::commit();
                        $data['s'] = "Data " . $this->ctitle . " " . $results_data->code . " berhasil dihapus";
                        $data['st'] = 's';
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data " . $this->ctitle . " gagal dihapus.";
                    }

                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal dihapus";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //---------ACTIVE---------------
    //------------------------------
    public function active($id)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';

                $is_actived = '';

                $id = dec($id);
                $results_data = Course::find($id);
                
                if($results_data){

                    if ($results_data->is_actived == 1) {
                        $is_actived = "nonaktifkan";
                        $results_data->is_actived = 0;
                    } else {
                        $is_actived = "aktifkan";
                        $results_data->is_actived = 1;
                    }

                    if($results_data->save()){
                        DB::commit();
                        $data['s'] = "Data " . $this->ctitle . " " . $results_data->name . " berhasil " . $is_actived;
                        $data['st'] = 's';
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data " . $this->ctitle . " gagal diubah.";
                    }

                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
                DB::rollBack();
                $data['s'] = "Data " . $this->ctitle . " gagal diubah";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //--------STORE SECTION---------
    //------------------------------
    public function store_section(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $course_id = dec($id);

                //VALIDATION
                if(!$request->title || !$request->position || !isset($request->is_actived)){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                // $results_data = Course::find($course_id);
                $results_data = $this->get_transaction($course_id)->first();
                if(!$results_data){
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $insert_data = new CourseSection();
                $insert_data->course_id = $results_data->id;
                $insert_data->title = $request->title;
                $insert_data->position = $request->position;
                $insert_data->is_actived = $request->is_actived;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data Konten " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Konten " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Konten " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }







    //------------------------------
    //--------UPDATE SECTION--------
    //------------------------------
    public function edit_section(Request $request, $id)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_section($id)->first();
        
        if ($results_data) {

            $course = $this->get_transaction($results_data->course_id)->first();
            if(!$course){
                return Redirect()->route('admin'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
            }

            return view($this->view_path . 'edit_section', compact('data', 'results_data'));
        } else return Redirect()->route('admin'.$this->has_access . '.index')->with("error", "Data Konten " . $this->ctitle . " tidak ditemukan.");
    }

    public function update_section(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                if(!$request->title || !$request->position || !isset($request->is_actived)){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = CourseSection::find($id);

                if($results_data){

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data->title = $request->title;
                    $results_data->position = $request->position;
                    $results_data->is_actived = $request->is_actived;
    
                    if($results_data->save()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Konten " . $this->ctitle . " berhasil diperbarui.";
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Konten " . $this->ctitle . " gagal diperbarui.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Konten " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Konten " . $this->ctitle . " gagal diperbarui.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }

    public function json_lesson(Request $request, $id){
        // Saat request ajax datatable
        if ($request->ajax()) {
            $id = dec($id);

            $data = new Lesson;
            $data = $data->select(
                'lessons.*', 
                'a.name as admins_name',
                )
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'lessons.course_section_id')
            ->leftJoin('users as a', 'a.id', '=', 'lessons.created_by')
            ->where('lessons.course_section_id', $id)
            ->whereNull("lessons.deleted_at");
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request){
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('lessons.title', 'like', $search_value)
                                ->orWhere('lessons.description', 'like', $search_value)
                                ->orWhere('lessons.type', 'like', $search_value)
                                ->orWhere('a.name', 'like', $search_value);
                        });
                    }
                })
                ->addColumn('vtitle', function ($row) {
                    $view = '<b>' . $row->title . '</b>';
                    return $view;
                })
                ->addColumn('vstatus_text', function ($row) {
                    if ($row->is_actived)  return 'menonaktifkan';
                    else return 'mengaktifkan';
                })
                ->addColumn('vstatus', function ($row) {
                    if ($row->is_actived) {
                        return '<span class="badge badge-primary">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('created_date', function ($row) {
                    $view = timestampf($row->created_at);
                    return $view;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="btn-group">
                        <button type="button"
                            class="btn btn-primary btn-sm dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">Aksi <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                    ';
                        
                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<a class="dropdown-item" name="btn_u" id="btn_u"><i class="fas fa-edit mr-2"></i> Ubah</a>';
                    // }

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" name="btn_ac" id="btn_ac"><i class="fas fa-lock mr-2"></i> Aktifkan</a>';
                    // }

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '<div class="dropdown-divider"></div>
                        <a class="dropdown-item" name="btn_dl" id="btn_dl"><i class="fas fa-trash mr-2"></i> Hapus</a>';
                    // }
                    
                    $btn .= '
                        </div>
                    </div>
                    ';

                    return $btn;
                })
                ->addColumn('up', function ($row) {
                    return $this->routes_path . 'edit_lesson/' . enc($row->id);
                })
                ->addColumn('ac', function ($row) {
                    return $this->routes_path . 'active_lesson/' . enc($row->id);
                })
                ->addColumn('dl', function ($row) {
                    return $this->routes_path . 'destroy_lesson/' . enc($row->id);
                })
                ->smart(true)
                ->startsWithSearch()
                ->rawColumns(['vtitle', 'vstatus', 'created_date', 'action'])
                ->toJson();
        }
    }






    //------------------------------
    //--------DELETE SECTION--------
    //------------------------------
    public function destroy_section(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                $results_data = CourseSection::find($id);

                if($results_data){

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    if($results_data->delete()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Konten " . $this->ctitle . " berhasil dihapus.";
                        $data['p'] = $this->routes_path . 'edit/'. enc($results_data->course_id);
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Konten " . $this->ctitle . " gagal dihapus.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Konten " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Konten " . $this->ctitle . " gagal dihapus.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //--------STORE LESSON----------
    //------------------------------
    public function create_lesson(Request $request, $id)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_section($id)->first();
        
        if ($results_data) {

            $course = $this->get_transaction($results_data->course_id)->first();
            if(!$course){
                return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
            }

            return view($this->view_path . 'create_lesson', compact('data', 'results_data'));
        } else return Redirect()->route('admin.'.$this->has_access . '.index')->with("error", "Data Konten " . $this->ctitle . " tidak ditemukan.");
    }

    public function store_lesson(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                if(!$request->title || !$request->position){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = CourseSection::find($id);

                if($results_data){

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }
    
                    $insert_data = new Lesson();
                    $insert_data->course_section_id = $results_data->id;
                    $insert_data->title = $request->title;
                    $insert_data->description = $request->description;
                    $insert_data->position = $request->position;
                    $insert_data->can_preview = $request->can_preview ?? 0;
                    $insert_data->url_video = $request->url_video;
                    $insert_data->type = Lesson::TYPE_VIDEO;

                    if($request->type){
                        $insert_data->type = $request->type;
                    }

                    if($insert_data->save()){
                        //Save Data
                        if($request->file()){
                            $validator = Validator::make($request->all(), [
                                'attachments' => 'array',
                                'attachments.*' => 'mimes:pdf|file|max:2048',
                            ]);
        
                            if($validator->passes()){
                                foreach($request->attachments as $k => $v){
                                    $name_gen = hexdec(uniqid());
                                    $image_ext = strtolower($v->getClientOriginalExtension());
                                    $file_name = 'course_'.date('Y_m_d').'_'.$k.'_'.$name_gen;
                                    $image_name = $file_name.'.'.$image_ext;
                                    $v->move(FileHelper::COURSE_SAVE_LOCATION, $image_name);
                                    
                                    $file = new LessonFile();
                                    $file->lesson_id = $insert_data->id;
                                    $file->files = $file_name;
                                    $file->extension = $image_ext;
                                    $file->save();
                                }
                            }
                            else{
                                DB::rollBack();
                                return response()->json(['s' => "Format foto tidak sesuai, harap periksa kembali format foto.", 'st' => 'e']);
                            }
                        }

                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Pelajaran " . $this->ctitle . " berhasil disimpan.";
                        $data['p'] = $this->routes_path . 'edit_section/' . enc($results_data->id);
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Pelajaran " . $this->ctitle . " gagal disimpan.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Konten " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Pelajaran " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //--------UPDATE LESSON---------
    //------------------------------
    public function edit_lesson(Request $request, $id)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_lesson($id)->first();
        
        if ($results_data) {

            $course_section = $this->get_section($results_data->course_section_id)->first();
            if(!$course_section){
                return Redirect()->route('admin.'.$this->has_access . '.index')->with("error", "Data Konten " . $this->ctitle . " tidak ditemukan.");
            }

            $course = $this->get_transaction($results_data->course_id)->first();
            if(!$course){
                return Redirect()->route('admin.'.$this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
            }

            $file_data = $this->get_transaction_lesson_file($results_data->id);

            if($results_data->type == Lesson::TYPE_QUIZ){
                return view($this->view_path . 'edit_lesson_quiz', compact('data', 'results_data', 'file_data'));
            } else {
                return view($this->view_path . 'edit_lesson', compact('data', 'results_data', 'file_data'));
            }
        } else return Redirect()->route('admin.'.$this->has_access . '.index')->with("error", "Data Konten " . $this->ctitle . " tidak ditemukan.");
    }

    public function update_lesson(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                if(!$request->title || !$request->position || !isset($request->can_preview)){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = $this->get_lesson($id)->first();

                if($results_data){

                    $course_section = $this->get_section($results_data->course_section_id)->first();
                    if(!$course_section){
                        return response()->json(['s' => "Data Konten " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data = Lesson::find($id);
    
                    $results_data->title = $request->title;
                    $results_data->description = $request->description;
                    $results_data->position = $request->position;
                    $results_data->can_preview = $request->can_preview;
                    $results_data->url_video = $request->url_video;

                    if($results_data->save()){
                        //Save Data
                        if($request->file()){
                            $validator = Validator::make($request->all(), [
                                'attachments' => 'array',
                                'attachments.*' => 'mimes:pdf|file|max:2048',
                            ]);
        
                            if($validator->passes()){
                                LessonFile::where('lesson_id', $results_data->id)->delete();

                                foreach($request->attachments as $k => $v){
                                    $name_gen = hexdec(uniqid());
                                    $image_ext = strtolower($v->getClientOriginalExtension());
                                    $file_name = 'course_'.date('Y_m_d').'_'.$k.'_'.$name_gen;
                                    $image_name = $file_name.'.'.$image_ext;
                                    $v->move(FileHelper::COURSE_SAVE_LOCATION, $image_name);
                                    
                                    $file = new LessonFile();
                                    $file->lesson_id = $results_data->id;
                                    $file->files = $file_name;
                                    $file->extension = $image_ext;
                                    $file->save();
                                }
                            }
                            else{
                                DB::rollBack();
                                return response()->json(['s' => "Format foto tidak sesuai, harap periksa kembali format foto.", 'st' => 'e']);
                            }
                        }

                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Pelajaran berhasil diperbarui.";
                        $data['p'] = $this->routes_path . 'edit_section/' . enc($results_data->course_section_id);
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Pelajaran gagal diperbarui.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Pelajaran tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Pelajaran gagal diperbarui.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }






    //------------------------------
    //--------DELETE LESSON---------
    //------------------------------
    public function destroy_lesson(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                $results_data = $this->get_lesson($id)->first();

                if($results_data){

                    $course_section = $this->get_section($results_data->course_section_id)->first();
                    if(!$course_section){
                        return response()->json(['s' => "Data Konten " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data = Lesson::find($id);
                    
                    if($results_data->delete()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Pelajaran berhasil dihapus.";
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Pelajaran gagal dihapus.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Pelajaran tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Pelajaran gagal dihapus.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }







    //------------------------------
    //--------ACTIVE LESSON---------
    //------------------------------
    public function active_lesson($id)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';

                $is_actived = '';

                $id = dec($id);
                $results_data = $this->get_lesson($id)->first();
                
                if($results_data){

                    $course_section = $this->get_section($results_data->course_section_id)->first();
                    if(!$course_section){
                        return response()->json(['s' => "Data Konten " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data = Lesson::find($id);

                    if ($results_data->is_actived == 1) {
                        $is_actived = "nonaktifkan";
                        $results_data->is_actived = 0;
                    } else {
                        $is_actived = "aktifkan";
                        $results_data->is_actived = 1;
                    }

                    if($results_data->save()){
                        DB::commit();
                        $data['s'] = "Data Pelajaran " . $results_data->title . " berhasil " . $is_actived;
                        $data['st'] = 's';
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Pelajaran gagal diubah.";
                    }

                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Pelajaran tidak ditemukan.";
                }
    
            } catch (Exception $e) {
                DB::rollBack();
                $data['s'] = "Data Pelajaran gagal diubah";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }






    //------------------------------
    //---STORE LEARN DESCRIPTION----
    //------------------------------
    public function store_learn_description(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $course_id = dec($id);

                //VALIDATION
                if(!$request->description){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = $this->get_transaction($course_id)->first();
                if(!$results_data){
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $insert_data = new CourseLearnDescription();
                $insert_data->course_id = $results_data->id;
                $insert_data->description = $request->description;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //---UPDATE LEARN DESCRIPTION---
    //------------------------------
    public function edit_learn_description(Request $request, $id)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_learn_description($id)->first();
        
        if ($results_data) {

            $course = $this->get_transaction($results_data->course_id)->first();
            if(!$course){
                return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
            }

            $results_data->enc = enc($results_data->id);

            $data['st'] = 's';
            $data['results_data'] = $results_data;
            return response()->json(['st' => $data['st'], 'results_data' => $data['results_data']]);
        } else return response()->json(['s' => "Data Poin Pembelajaran " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
    }

    public function update_learn_description(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                //VALIDATION
                if(!$request->description){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = $this->get_learn_description($id)->first();

                if($results_data){

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data = CourseLearnDescription::find($id);
                    $results_data->description = $request->description;
    
                    if($results_data->save()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " berhasil diperbarui.";
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " gagal diperbarui.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Poin Pembelajaran " . $this->ctitle . " gagal diperbarui.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }








    //------------------------------
    //---DELETE LEARN DESCRIPTION---
    //------------------------------
    public function destroy_learn_description(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                $results_data = $this->get_learn_description($id)->first();

                if($results_data){

                    $course = $this->get_transaction($results_data->course_id)->first();
                    if(!$course){
                        return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                    }

                    $results_data = CourseLearnDescription::find($id);
                    
                    if($results_data->delete()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Poin Pembelajaran berhasil dihapus.";
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Poin Pembelajaran gagal dihapus.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Poin Pembelajaran tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Poin Pembelajaran gagal dihapus.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }









    //------------------------------
    //---------MEMBER---------------
    //------------------------------
    public function member_course($id, Request $request)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_transaction($id)->first();
        
        if ($results_data) {

            return view($this->view_path . 'member', compact('data', 'results_data'));
        } else return Redirect()->route('admin.'. $this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }

    public function json_member_course(Request $request){
        // Saat request ajax datatable
        if ($request->ajax()) {
            $course_id = dec($request->id);

            $asset = new CourseMember;
            $asset = $asset->select(
                'course_members.*', 
                'm.email as member_email',
                'm.name as member_name',
                'm.phone as member_phone',
                'a.name as admins_name',
                )
            ->leftJoin('users as m', 'm.id', '=', 'course_members.member_id')
            ->leftJoin('users as a', 'a.id', '=', 'course_members.created_by')
            ->where('course_members.course_id', $course_id)
            ->whereNull("course_members.deleted_at");
            return DataTables::of($asset)
                ->addIndexColumn()
                ->filter(function ($query) use ($request){
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('course_members.code', 'like', $search_value)
                                ->orWhere('m.email', 'like', $search_value)
                                ->orWhere('m.name', 'like', $search_value)
                                ->orWhere('m.phone', 'like', $search_value)
                                ->orWhere('a.name', 'like', $search_value);
                        });
                    }
                })
                ->addColumn('created_date', function ($row) {
                    $view = timestampf($row->created_at);
                    return $view;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="btn-group">
                        <button type="button"
                            class="btn btn-primary btn-sm dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">Aksi <i class="mdi mdi-chevron-down"></i></button>
                        <div class="dropdown-menu">
                    ';

                    // if (has_access($this->has_access, "updated")) {
                        $btn .= '
                        <a class="dropdown-item" name="btn_dl" id="btn_dl"><i class="fas fa-trash mr-2"></i> Hapus</a>';
                    // }
                    
                    $btn .= '
                        </div>
                    </div>
                    ';

                    return $btn;
                })
                ->addColumn('dl', function ($row) {
                    return $this->routes_path . 'delete_member_course/' . enc($row->id);
                })
                ->smart(true)
                ->startsWithSearch()
                ->rawColumns(['vname', 'vlevel', 'vprice', 'vstatus', 'created_date', 'action'])
                ->toJson();
        }
    }











    //------------------------------
    //--------STORE MEMBER----------
    //------------------------------
    public function store_member_course(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $course_id = dec($id);

                //VALIDATION
                if(!$request->member_id){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $results_data = $this->get_transaction($course_id)->first();
                if(!$results_data){
                    return response()->json(['s' => "Data " . $this->ctitle . " tidak ditemukan.", 'st' => 'e']);
                }

                $member = User::find(dec($request->member_id));
                if(!$member){
                    return response()->json(['s' => "Data Member tidak ditemukan.", 'st' => 'e']);
                }

                $member_course = CourseMember::where('member_id', $member->id)->where('course_id', $results_data->id)->first();
                if($member_course){
                    return response()->json(['s' => "Data Member ". $this->ctitle ." sudah ada pada ". $this->ctitle ." ini.", 'st' => 'e']);
                }

                $insert_data = new CourseMember();
                $insert_data->course_id = $results_data->id;
                $insert_data->member_id = $member->id;
                $insert_data->course_price = $results_data->price;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['s'] = "Data Member " . $this->ctitle . " berhasil disimpan.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Member " . $this->ctitle . " gagal disimpan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Member " . $this->ctitle . " gagal disimpan.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }









    //------------------------------
    //--------DELETE MEMBER---------
    //------------------------------
    public function delete_member_course(Request $request, $id)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $id = dec($id);

                $results_data = $this->get_member_course($id)->first();

                if($results_data){

                    $results_data = CourseMember::find($id);
                    
                    if($results_data->delete()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data Member ". $this->ctitle ." berhasil dihapus.";
                    }
                    else{
                        DB::rollBack();
                        $data['s'] = "Data Member ". $this->ctitle ." gagal dihapus.";
                    }
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Member ". $this->ctitle ." tidak ditemukan.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Member ". $this->ctitle ." gagal dihapus.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
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
            ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
            ->where('courses.id', $id);
        return $results_data;
    }

    public function get_transaction_section($id)
    {
        $results_data = CourseSection::select('course_sections.*')
            ->where('course_sections.course_id', $id)
            ->orderBy('course_sections.position', 'asc')
            ->get();
        return $results_data;
    }

    public function get_transaction_learn_description($id)
    {
        $results_data = CourseLearnDescription::
            select('course_learn_descriptions.*')
            ->where('course_learn_descriptions.course_id', $id)
            ->get();
        return $results_data;
    }

    public function get_transaction_lesson_file($id)
    {
        $results_data = LessonFile::select('lesson_files.*')
            ->where('lesson_files.lesson_id', $id)
            ->get();
        return $results_data;
    }

    public function get_transaction_category($id){
        $results_data = CourseCategory::select(
            'course_categories.*', 
            'cc.name as category_name', 
            'cc.code as category_code',
            )
            ->leftJoin('category_courses as cc', 'cc.id', '=', 'course_categories.category_course_id')
            ->where('course_categories.course_id', $id)
            ->get();
        return $results_data;
    }

    public function get_section($id){
        $results_data = CourseSection::select(
            'course_sections.*', 
            'l.name as level_name', 
            'c.title as course_title', 
            )
            ->leftJoin('courses as c', 'c.id', '=', 'course_sections.course_id')
            ->leftJoin('levels as l', 'l.id', '=', 'c.level_id')
            ->where('course_sections.id', $id);
        return $results_data;
    }

    public function get_lesson($id){
        $results_data = Lesson::select(
            'lessons.*', 
            'c.id as course_id', 
            )
            ->leftJoin('course_sections as cs', 'cs.id', '=', 'lessons.course_section_id')
            ->leftJoin('courses as c', 'c.id', '=', 'cs.course_id')
            ->where('lessons.id', $id);
        return $results_data;
    }

    public function get_learn_description($id)
    {
        $results_data = CourseLearnDescription::
            select('course_learn_descriptions.*')
            ->where('course_learn_descriptions.id', $id);
        return $results_data;
    }

    public function get_member_course($id)
    {
        $results_data = CourseMember::
            select('course_members.*')
            ->where('course_members.id', $id);
        return $results_data;
    }







    //------------------------------
    //---------SELECT2--------------
    //------------------------------
    public function search_level(Request $request){
        $data = Level::select('levels.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('levels.name', 'like', $search_value);
            })
            ->where('levels.is_actived', '1')
            ->orderBy('levels.name', 'asc')
            ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
        }
        return json_encode($data);
    }

    public function search_category(Request $request){
        $data = CategoryCourse::select('category_courses.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('category_courses.name', 'like', $search_value);
            })
            ->where('category_courses.is_actived', '1')
            ->orderBy('category_courses.name', 'asc')
            ->get();

        return json_encode($data);
    }

    public function search_member(Request $request){
        $data = User::select('users.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('users.name', 'like', $search_value)
                ->orWhere('users.email', 'like', $search_value);
            })
            ->where('users.role', User::MEMBER)
            ->where('users.is_actived', '1')
            ->orderBy('users.name', 'asc')
            ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
        }
        return json_encode($data);
    }

}
