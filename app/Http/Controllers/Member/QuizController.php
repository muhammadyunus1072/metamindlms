<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class QuizController extends Controller
{
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        return view('member.pages.course_member.quiz.show');
    }
}
