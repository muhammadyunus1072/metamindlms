<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class CourseCategory extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function category_course()
    {
        return $this->belongsTo(Category::class, 'category_course_id', 'id');
    }
}
