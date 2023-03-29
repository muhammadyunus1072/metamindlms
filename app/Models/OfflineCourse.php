<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourse extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'title',
        'description',
        'quota',
        'date_time_start',
        'date_time_end',
        'image',
    ];

    public function getImage()
    {
        return $this->image ? FileHelper::OFFLINE_COURSE_READ_LOCATION . $this->image : null;
    }

    public function offlineCourseCategories()
    {
        return $this->hasMany(OfflineCourseCategory::class, "offline_course_id", 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryCourse::class, 'offline_course_categories', 'offline_course_id', 'category_course_id')->whereNull('offline_course_categories.deleted_at');
    }

    public function attendances()
    {
        return $this->hasMany(OfflineCourseAttendance::class, 'offline_course_id', 'id');
    }

    public function registrars()
    {
        return $this->hasMany(OfflineCourseRegistrar::class, 'offline_course_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(OfflineCourseAttachment::class, 'offline_course_id', 'id');
    }
}
