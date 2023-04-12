<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class Lesson extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    const TYPE_VIDEO = 'video';
    const TYPE_QUIZ = 'quiz';

    //Relation
    public function course()
    {
        return $this->hasOneThrough(Course::class, CourseSection::class, 'id', 'id', 'course_section_id', 'course_id');
    }

    public function questions()
    {
        return $this->hasMany(LessonQuestion::class, 'lesson_id','id');
    }

    //Attribut
    public function lesson_icon($is_member){
        if ($this->can_preview || $is_member) {
            if ($this->type === self::TYPE_VIDEO) {
                return 'play_circle_outline';
            } else if($this->type === self::TYPE_QUIZ){
                return 'hourglass_empty';
            }
        } else {
            return 'lock';
        }
        
    }

    public function lesson_icon_learning($user_id){
        if ($this->is_done_by_user($user_id)) {
            return 'check_circle';
        } else {
            return 'play_circle_outline';
        }
    }

    public function is_done_by_user($user_id){
        return Lesson::select(
                    'lessons.*'
                )
                ->leftJoin('course_member_lessons as cml', 'cml.lesson_id', '=', 'lessons.id')
                ->where('cml.is_done', '1')
                ->where('lessons.id', $this->id)
                ->where('cml.member_id', $user_id)
                ->first();
    }
}
