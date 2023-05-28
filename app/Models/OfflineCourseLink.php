<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourseLink extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'offline_course_id',
        'url',
        'url_name',
        'title',
    ];

    public function offlineCourse()
    {
        return $this->belongsTo(OfflineCourse::class, 'offline_course_id', 'id');
    }
}
