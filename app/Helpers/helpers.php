<?php

use App\Models\Course;
use App\Models\StatusProject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

## ENCRIPT
function enc($v = null)
{
    if (empty($v)) Redirect('');
    $id = str_replace("/", "+258147369+", Crypt::encryptString($v));
    if (!empty($id) && $id != null && $id != '') return $id;
    else Redirect('');
}

## DECRYPT 2
function dec($v = null)
{
    if (empty($v)) Redirect('');
    $id =  Crypt::decryptString(str_replace("+258147369+", "/", $v));
    if (!empty($id) && $id != null && $id != '') return $id;
    else Redirect('');
}

function timestampf($data)
{
    if(empty($data)) return '-';
    else return date("d M Y, H:i:s", strtotime($data));
}

function timef($data = null){
    if(empty($data)) return '-';
    else return date("H:i", strtotime($data));
}

function sql_datef($data = null)
{
    if (empty($data)) return '-';
    return date("Y-m-d", strtotime($data));
}

function numberf($data = null){
    if(empty($data)) return '-';
    else return number_format($data,2,".",",");
}

function number_rating($data = null){
    if(empty($data)) return '-';
    else return number_format($data,1,".",",");
}

function time_diff_for_human($data = null){
    Carbon::setLocale('id');

    if(empty($data)) return '-';
    else return Carbon::parse($data)->diffForHumans();
}

function percentage($value = null, $total_value = null)
{
    if (empty($value) || empty($total_value)) return 0;
    else return round((($value / $total_value) * 100), 2);
}

function response_json($data = null){
    if(empty($data)){
        return '-';
    }
    else {
        // $s_data = array();
        if(array_key_exists('m', $data)){
            $data['s'] .= ' ' . $data['m'];
        }

        // if(array_key_exists('p', $data)){
        //     return response()->json(['s' => $data['s'], 'st' => $data['st'], 'p' => $data['p']]);
        // }
        // else{
        //     return response()->json(['s' => $data['s'], 'st' => $data['st'], 'd' =>$data['d']]);
        // }
        return response()->json($data);
    }
}



//-----------------------
//--------USER-----------
//-----------------------
function info_user()
{
    if(!Auth::check()) return null;
    return Auth::user();
}

function info_user_id()
{
    if(!Auth::check()) return null;
    return Auth::user()->id;
}






//-----------------------

const MASTER_SIDEBAR = array(
    "group_category_course" => "Grup Kategori",
    "category_course" => "Kategori Kursus",
    "level" => "Level Kursus",
    "course" => "Kursus",
    "offline_course" => "Kursus Offline",
    "course_member" => "Kursus Member",
    "recap_course" => "Rekap Kursus",
    "account_member" => "Akun Member",
    "account_admin" => "Akun Admin",
);

function master_sidebar($key = null){
    if(empty($key)) return '-';
    else return MASTER_SIDEBAR[$key];
}

const MASTER_STRING = array(
    "video" => "Video",
    "quiz" => "Kuis",
);

function master_string($key = null){
    if(empty($key)) return '-';
    else return MASTER_STRING[$key];
}
