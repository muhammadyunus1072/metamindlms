<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Sis\TrackHistory\HasTrackHistory;

class Course extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    //Relation
    public function categories()
    {
        return $this->hasMany(CourseCategory::class, 'course_id', 'id');
    }

    public function course_sections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id');
    }

    public function learn_description()
    {
        return $this->hasMany(CourseLearnDescription::class, 'course_id', 'id');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, CourseSection::class, 'course_id', 'course_section_id', 'id', 'id')->where('course_sections.is_actived', '1')->where('lessons.is_actived', '1');
    }

    //Track History
    protected static function onBoot()
    {
        self::creating(function ($model) {
            $model->code = self::generateCode();
        });
    }

    public static function generateCode()
    {
        $numberLength = 8;
        // Get Last Number
        $lastModel = self::orderBy('id', 'DESC')->withTrashed()->first();
        if (!empty($lastModel)) {
            $lastNumber = $lastModel->id;
        } else {
            $lastNumber = 0;
        }

        // Get Current Number
        $currentNumber = strval($lastNumber + 1);
        $currentNumber = str_pad($currentNumber, $numberLength, "0", STR_PAD_LEFT);

        // Generate Format Number
        $formattedNumber = "COR-$currentNumber";

        return $formattedNumber;
    }

    //Attribut
    public function is_favorite(){
        return CourseFavorite::where('course_id', $this->id)->where('member_id', info_user_id())->first() !== null;
    }

    public function rating(){
        return CourseReview::where('course_id', $this->id)->whereNull('deleted_at')->avg('rating');
    }

    public function rating_by_star($rating){
        return CourseReview::where('course_id', $this->id)->where('rating', $rating)->whereNull('deleted_at')->count('id');
    }

    public function ellipsis_description(){
        $len = 200;
        if(strlen($this->description) > $len){
            return substr($this->description, 0, 200) . '...';
        }
        return $this->description;
    }

    public function avg_rating_by_star($rating){
        if($this->review() <= 0){
            return numberf(0);
        }
        else{
            return numberf(($this->rating_by_star($rating) / $this->review()) * 100) ;
        }
    }

    public function review(){
        return CourseReview::where('course_id', $this->id)->whereNull('deleted_at')->count('id');
    }

    public function review_by_user($user_id){
        return CourseReview::
            select(
                'course_reviews.*',
            )
            ->where('course_reviews.course_id', $this->id)
            ->where('course_reviews.member_id', $user_id)
            ->first();
    }

    //Static Function
    public static function course_popular(){
        return Course::select('courses.*', 'l.name as level_name')
        ->leftJoin('levels as l', 'l.id', '=', 'courses.level_id')
        // ->leftJoin('course_categories as cc', 'cc.id', '=', 'courses.category_id')
        ->paginate(10);
    }
}
