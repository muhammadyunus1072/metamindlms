<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class TransactionDetailOfflineCourse extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        "transaction_detail_id",
        "offline_course_id",

        "offline_course_title",
        "offline_course_description",
        "offline_course_content",
        "offline_course_quota",
        "offline_course_date_time_start",
        "offline_course_date_time_end",
        "offline_url_online_meet",
    ];

    protected static function onBoot()
    {
        self::created(function ($model) {
            $offlineCourseRegistrar = new OfflineCourseRegistrar();
            $offlineCourseRegistrar->offline_course_id = $model->offline_course_id;
            $offlineCourseRegistrar->user_id = info_user_id();
            $offlineCourseRegistrar->save();
        });
    }

    public function offlineCourse()
    {
        return $this->belongsTo(offlineCourse::class, 'offline_course_id', 'id');
    }
}
