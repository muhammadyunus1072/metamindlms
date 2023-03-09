<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseSection extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    //Relation
    public function lesson()
    {
        return $this->hasMany(Lesson::class, 'course_section_id', 'id')->orderBy('position', 'asc');
    }

    public function lesson_active()
    {
        return $this->hasMany(Lesson::class, 'course_section_id', 'id')->where('is_actived', '1')->orderBy('position', 'asc');
    }

    //Attribute
    public function lesson_status_by_user($user_id, $status = null){
        $query = Lesson::
                    select(
                        'lessons.*',
                    )
                    ->leftJoin('course_member_lessons as cml', 'cml.lesson_id', '=', 'lessons.id')
                    ->where('course_section_id', $this->id)
                    ->where('cml.member_id', $user_id);

        if(isset($status)){
            if($status){
                $query = $query->where('cml.is_done', '1');
            }
            else{
                $query = $query->where('cml.is_done', '0');
            }
        }

        return $query->get();
    }
}
