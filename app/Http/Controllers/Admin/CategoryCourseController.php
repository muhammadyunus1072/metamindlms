<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryCourse;
use App\Models\GroupCategoryCourse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryCourseController extends Controller
{
    private $ctitle = "Kategori Kursus";
    private $view_path = "admin.pages.master.category_course.";
    private $routes_path;
    private $has_access = "category_course";

    public function __construct()
    {
        $this->routes_path = route('admin.category_course.index') . "/";
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
            $asset = new CategoryCourse;
            $asset = $asset->select(
                'category_courses.*', 
                'gcc.name as group_category_course_name',
                'a.name as admins_name',
                )
            ->leftJoin('group_category_courses as gcc', 'gcc.id', '=', 'category_courses.group_category_course_id')
            ->leftJoin('admins as a', 'a.id', '=', 'category_courses.created_by')
            ->whereNull("category_courses.deleted_at");
            return DataTables::of($asset)
                ->addIndexColumn()
                ->filter(function ($query) use ($request){
                    if ($request->search['value']) {
                        $search_value = '%' . $request->search['value'] . '%';
                        $query->where(function ($query) use ($search_value) {
                            $query->where('category_courses.code', 'like', $search_value)
                                ->orWhere('category_courses.name', 'like', $search_value)
                                ->orWhere('a.name', 'like', $search_value);
                        });
                    }
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
                ->rawColumns(['vstatus', 'created_date', 'action'])
                ->toJson();
        }
    }







    
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
                if(!$request->name){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $group_category_course = GroupCategoryCourse::find(dec($request->group_category_course_id));

                if(!$group_category_course){
                    DB::rollBack();
                    return response()->json(['s' => "Grup Kategori tidak ditemukan.", 'st' => 'e']);
                }
    
                $results_data = new CategoryCourse();
                $results_data->group_category_course_id = $group_category_course->id;
                $results_data->name = $request->name;
                // $results_data->icon = $request->icon;
                $results_data->description = $request->description;

                if($results_data->save()){
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









    public function edit($id, Request $request)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();
        $id = dec($id);

        $results_data = $this->get_transaction($id)->first();
        
        if ($results_data) {

            return view($this->view_path . 'edit', compact('data', 'results_data'));
        } else return Redirect()->route($this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }

    public function update($id, Request $request)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
    
                $id = dec($id);            

                //VALIDATION
                if(!$request->name){
                    DB::rollBack();
                    return response()->json(['s' => "Terdapat data yang belum diisi, Harap melengkapi seluruh data sebelum disimpan.", 'st' => 'e']);
                }

                $group_category_course = GroupCategoryCourse::find(dec($request->group_category_course_id));

                if(!$group_category_course){
                    DB::rollBack();
                    return response()->json(['s' => "Grup Kategori tidak ditemukan.", 'st' => 'e']);
                }

                $results_data = CategoryCourse::find($id);
    
                if($results_data){
                    $results_data->group_category_course_id = $group_category_course->id;
                    $results_data->name = $request->name;
                    // $results_data->icon = $request->icon;
                    $results_data->description = $request->description;
        
                    if($results_data->save()){
                        DB::commit();
                        $data['st'] = 's';
                        $data['s'] = "Data " . $this->ctitle . " berhasil diperbarui.";
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










    public function destroy($id)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';

                $id = dec($id);
                $results_data = CategoryCourse::find($id);
                

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









    public function active($id)
    {
        if(request()->ajax()){
            try {
                DB::beginTransaction();

                $data = array();
                $data['st'] = 'e';

                $is_actived = '';

                $id = dec($id);
                $results_data = CategoryCourse::find($id);
                
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
    //----------DATA----------------
    //------------------------------
    public function get_transaction($id)
    {
        $results_data = CategoryCourse::select(
            'category_courses.*', 
            'gcc.name as group_category_name',  
            )
            ->leftJoin('group_category_courses as gcc', 'gcc.id', '=', 'category_courses.group_category_course_id')
            ->where('category_courses.id', $id);
        return $results_data;
    }









    //------------------------------
    //---------SELECT2--------------
    //------------------------------
    public function search_group_category(Request $request){
        $data = GroupCategoryCourse::select('group_category_courses.*')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('group_category_courses.name', 'like', $search_value);
            })
            ->where('group_category_courses.is_actived', '1')
            ->orderBy('group_category_courses.name', 'asc')
            ->get();

        foreach ($data as $v) {
            $v->enc_id = enc($v->id);
        }
        return json_encode($data);
    }
}
