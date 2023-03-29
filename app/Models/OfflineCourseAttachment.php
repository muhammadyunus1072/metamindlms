<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourseAttachment extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'offline_course_id',
        'file',
        'file_name',
    ];

    public function getFile()
    {
        return $this->file ? FileHelper::OFFLINE_COURSE_READ_LOCATION . $this->file : null;
    }

    public function offlineCourse()
    {
        return $this->belongsTo(OfflineCourse::class, 'offline_course_id', 'id');
    }
}
