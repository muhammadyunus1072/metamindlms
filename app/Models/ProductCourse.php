<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class ProductCourse extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
