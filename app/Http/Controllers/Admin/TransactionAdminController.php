<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonFile;
use App\Models\Transaction;
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

class TransactionAdminController extends Controller
{
    private $ctitle = "Transaksi";
    private $view_path = "admin.pages.transaction.";
    private $routes_path;
    private $has_access = "transaction";

    public function __construct()
    {
        $this->routes_path = route('admin.transaction.index') . "/";
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
        $transaction = $this->get_data();
        return view("admin.pages.transaction.index", compact('transaction'));
    }
    public function detail($id) 
    {
        $transaction_id = $id;
        return view("admin.pages.transaction.detail", compact('transaction_id'));
    }

    //------------------------------
    //----------DATA----------------
    //------------------------------

    public function get_data()
    {
        $data = Transaction::with('transactionDetails', 'status')->get();
        return $data;
    }
    
}
