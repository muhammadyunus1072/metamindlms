<?php

use App\Models\Course;
use App\Models\StatusProject;
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

function numberf($data = null){
    if(empty($data)) return '-';
    else return number_format($data,2,".",",");
}

function response_json($data = null){
    if(empty($data)){
        return '-';
    }
    else {

        if(array_key_exists('m', $data)){
            $data['s'] .= ' ' . $data['m'];
        }

        if(array_key_exists('p', $data)){
            return response()->json(['s' => $data['s'], 'st' => $data['st'], 'p' => $data['p']]);
        }
        else{
            return response()->json(['s' => $data['s'], 'st' => $data['st']]);
        }
    }
}

//-----------------------

const MASTER_SIDEBAR = array(
    "group_category_course" => "Grup Kategori",
    "category_course" => "Kategori Kursus",
    "level" => "Level Kursus",
    "course" => "Kursus",
    "offline_course" => "Kursus Offline",
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


//View
function course_item_sm($id = null){
    if(empty($id)) return;
    
    $id = dec($id);
    $results_data = Course::select('courses.*', 'l.name as level_name')
                                ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
                                // ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
                                ->where('id', $id)
                                ->first();

    $learn_description_text = "";
    
    foreach($results_data->learn_description as $v){
        $learn_description_text .= '
        <div class="d-flex align-items-top">
            <span class="material-icons icon-16pt text-50 mr-8pt">check</span>
            <p class="flex text-50 lh-1 mb-0 text-justify"><small>'. $v->description .'</small></p>
        </div>
        ';
    }

    $view = '
    <div class="col-md-6 col-lg-4 col-xl-3 card-group-row__col">

        <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay mdk-reveal js-mdk-reveal card-group-row__card"
                
                data-partial-height="44"
                data-toggle="popover"
                data-trigger="click">

            <a href="student-course.html"
                class="js-image"
                data-position="">
                <img src="'. asset('/assets/images/paths/mailchimp_430x168.png') .'
                        alt="course">
                <span class="overlay__content align-items-start justify-content-start">
                    <span class="overlay__action card-body d-flex align-items-center">
                        <i class="material-icons mr-4pt">play_circle_outline</i>
                        <span class="card-title text-white">Preview</span>
                    </span>
                </span>
            </a>

            <div class="mdk-reveal__content">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex">
                            <a class="card-title"
                                href="student-course.html">'. $results_data->title .'</a>
                            <small class="text-50 font-weight-bold mb-4pt">'. $results_data->level_name .'</small>
                        </div>
                        <a href="student-course.html"
                            data-toggle="tooltip"
                            data-title="Remove Favorite"
                            data-placement="top"
                            data-boundary="window"
                            class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite</a>
                    </div>
                    <div class="d-flex">
                        <div class="rating flex">
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star</span></span>
                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                        </div>
                        <small class="text-50">6 hours</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="popoverContainer d-none">
            <div class="media">
                <div class="media-left mr-12pt">
                    <img src="../../public/images/paths/mailchimp_40x40@2x.png"
                            width="40"
                            height="40"
                            alt="Angular"
                            class="rounded">
                </div>
                <div class="media-body">
                    <div class="card-title mb-0">'. $results_data->title .'</div>
                    <p class="lh-1 mb-0">
                        <span class="text-50 small font-weight-bold">'. $results_data->level_name .'</span>
                    </p>
                </div>
            </div>

            <p class="my-16pt text-70">'. $results_data->description .'</p>

            <div class="mb-16pt">
                '. $learn_description_text .'
            </div>

            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="d-flex align-items-center mb-4pt">
                        <span class="material-icons icon-16pt text-50 mr-4pt">access_time</span>
                        <p class="flex text-50 lh-1 mb-0"><small>6 hours</small></p>
                    </div>
                    <div class="d-flex align-items-center mb-4pt">
                        <span class="material-icons icon-16pt text-50 mr-4pt">play_circle_outline</span>
                        <p class="flex text-50 lh-1 mb-0"><small>12 lessons</small></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="material-icons icon-16pt text-50 mr-4pt">assessment</span>
                        <p class="flex text-50 lh-1 mb-0"><small>Beginner</small></p>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="student-course.html"
                        class="btn btn-primary">Lihat Trailer</a>
                </div>
            </div>

        </div>

    </div>
    ';
}