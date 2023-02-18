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
}
