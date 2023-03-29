<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourseAttendance extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'offline_course_registrar_id',
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $registrar = $model->offlineCourseRegistrar;

            $model->offline_course_id = $registrar->offline_course_id;

            $model->user_id = $registrar->user_id;
            $model->user_name = $registrar->user_name;
            $model->user_email = $registrar->user_email;
            $model->user_phone = $registrar->user_phone;
            $model->user_birth_place = $registrar->user_birth_place;
            $model->user_birth_date = $registrar->user_birth_date;
            $model->user_gender = $registrar->user_gender;
            $model->user_religion = $registrar->user_religion;
            $model->user_company_name = $registrar->user_company_name;
        });

        self::updating(function ($model) {
            if ($model->offline_course_registrar_id != $model->getOriginal('offline_course_registrar_id')) {
                $registrar = $model->offlineCourseRegistrar;

                $model->offline_course_id = $registrar->offline_course_id;

                $model->user_id = $registrar->user_id;
                $model->user_name = $registrar->user_name;
                $model->user_email = $registrar->user_email;
                $model->user_phone = $registrar->user_phone;
                $model->user_birth_place = $registrar->user_birth_place;
                $model->user_birth_date = $registrar->user_birth_date;
                $model->user_gender = $registrar->user_gender;
                $model->user_religion = $registrar->user_religion;
                $model->user_company_name = $registrar->user_company_name;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offlineCourse()
    {
        return $this->belongsTo(OfflineCourse::class, 'offline_course_id', 'id');
    }

    public function offlineCourseRegistrar()
    {
        return $this->belongsTo(OfflineCourseRegistrar::class, 'offline_course_registrar_id', 'id');
    }
}
