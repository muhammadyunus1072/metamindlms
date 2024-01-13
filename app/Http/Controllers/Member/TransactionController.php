<?php

namespace App\Http\Controllers\Member;

use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\CourseReview;
use Illuminate\Http\Request;
use App\Models\CourseSection;
use App\Models\CategoryCourse;
use App\Models\CourseFavorite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseLearnDescription;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    private $ctitle = "Riwayat Transaksi";
    private $view_path = "member.pages.transaction.";
    private $routes_path;
    private $has_access = "transaction";

    public function __construct()
    {
        $this->routes_path = route('member.transaction.index') . "/";
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
        return view("member.pages.transaction.index");
    }
    public function detail($id) 
    {
        $transaction_id = $id;
        return view("member.pages.transaction.detail", compact('transaction_id'));
    }



    //------------------------------
    //---------PRODUCT CART-------------
    //------------------------------
    public function store_product_to_cart(Request $request)
    {
        // if (!has_access($this->has_access, "view")) return abort(403);

        if(request()->ajax()){
            try {
                DB::beginTransaction();
                
                $data = array();
                $data['st'] = 'e';
                $product_id = dec($request->product_id);
                
                
                $member = User::where('role', User::MEMBER)->where('id', info_user_id())->first();
                if(!$member){
                    return response()->json(['s' => "Data Member tidak ditemukan.", 'st' => 'e']);
                }

                if($this->is_product_in_cart($product_id))
                {
                    return response()->json(['s' => "Kursus sudah ada dalam keranjang.", 'st' => 'e']);
                }

                $insert_data = new Cart();
                $insert_data->product_id = $product_id;
                $insert_data->user_id = $member->id;

                if($insert_data->save()){
                    DB::commit();
                    $data['st'] = 's';
                    $data['d'] = 1;
                    $data['s'] = "Kursus berhasil masuk keranjang anda.";
                }
                else{
                    DB::rollBack();
                    $data['s'] = "Data Kursus gagal masuk keranjang.";
                }
    
            } catch (Exception $e) {
    
                DB::rollBack();
                $data['s'] = "Data Kursus gagal masuk keranjang.";
                $data['m'] = $e->getMessage();
            }
            return response_json($data);
        }
    }

    //------------------------------
    //----------DATA----------------
    //------------------------------

    public function is_product_in_cart($product_id)
    {
        $product = Cart::where('user_id', info_user_id())
        ->where('product_id', $product_id)
        ->first();
        if(!$product){
            return false;
        }
        return true;
    }
    
}
