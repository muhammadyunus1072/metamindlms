<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptionHelper;
use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\CategoryCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.master.product.index');
    }

    public function create(Request $request)
    {
        return view('admin.pages.master.product.detail', ['product' => null]);
    }

    public function edit(Request $request)
    {
        $decId = Crypt::decryptString($request->id);
        $product = Product::where('id', $decId)->with(
            'productCourses', 
            'productCourses.course', 
            'productOfflineCourses',
            'productOfflineCourses.offlineCourse',
        )->first();

        // return $product;
        return view('admin.pages.master.product.detail', ['product' => $product]);
    }

    public function show(Request $request)
    {
        $decId = Crypt::decryptString($request->id);
        $product = Product::find($decId);

        return view('admin.pages.master.product.show', ['product' => $product]);
    }

}
