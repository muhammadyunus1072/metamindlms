<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountAdminController extends Controller
{
    public function index()
    {
        return view('admin.pages.account_admin.index');
    }

    public function create(Request $request)
    {
        return view('admin.pages.account_admin.detail', ['user_id' => null]);
    }

    public function edit(Request $request)
    {
        return view('admin.pages.account_admin.detail', ['user_id' => $request->id]);
    }
}
