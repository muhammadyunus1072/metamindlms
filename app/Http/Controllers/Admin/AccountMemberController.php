<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountMemberController extends Controller
{
    public function index()
    {
        return view('admin.pages.account-member.index');
    }

    public function create(Request $request)
    {
        return view('admin.pages.account-member.detail', ['user_id' => null]);
    }

    public function edit(Request $request)
    {
        return view('admin.pages.account-member.detail', ['user_id' => $request->id]);
    }
}
