<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $ctitle = "Profile";
    private $view_path = "member.pages.profile.";
    private $routes_path;
    private $has_access = "profile";

    public function __construct()
    {
        // $this->routes_path = route('member.profile.index') . "/";
    }

    public function get_etc()
    {
        $data = array();
        $data = $this->meta_data($data);
        $data['ctitle'] = $this->ctitle;
        // $data['croute'] = $this->routes_path;
        $data['has_access'] = $this->has_access;
        return $data;
    }









    //------------------------------
    //---------UPDATE---------------
    //------------------------------
    public function edit(Request $request)
    {
        // if (!has_access($this->has_access, "updated")) return abort(403);

        $data = $this->get_etc();

        $results_data = info_user();
        
        if ($results_data) {

            return view($this->view_path . 'edit', compact('data', 'results_data'));
        } else return Redirect()->route('admin.'. $this->has_access . '.index')->with("error", "Data " . $this->ctitle . " tidak ditemukan.");
    }

    public function update(Request $request)
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
    
                $results_data = User::find(info_user_id());

                if($results_data){
    
                    $results_data->name = $request->name;
                    $results_data->phone = $request->phone;
                    $results_data->gender = $request->gender;
                    $results_data->religion = $request->religion;
                    $results_data->birth_place = $request->birth_place;
                    $results_data->birth_date = $request->birth_date;
                    $results_data->company_name = $request->company_name;

                    if($request->password){
                        if($request->password != $request->password_confirmation){
                            DB::rollBack();
                            return response()->json(['s' => "Password yang dimasukkan tidak sama, Silahkan periksa kembali.", 'st' => 'e']);
                        }
                        else{
                            $results_data->password = Hash::make($request->password);
                        }
                    }

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
}
