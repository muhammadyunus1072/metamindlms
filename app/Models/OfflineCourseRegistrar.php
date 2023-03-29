<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sis\TrackHistory\HasTrackHistory;

class OfflineCourseRegistrar extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'offline_course_id',
        'user_id',
    ];

    protected static function onBoot()
    {
        self::creating(function ($model) {
            $user = $model->user;
            $model->user_name = $user->name;
            $model->user_email = $user->email;
            $model->user_phone = $user->phone;
            $model->user_birth_place = $user->birth_place;
            $model->user_birth_date = $user->birth_date;
            $model->user_gender = $user->gender;
            $model->user_religion = $user->religion;
            $model->user_company_name = $user->company_name;
        });

        self::updating(function ($model) {
            if ($model->user_id != $model->getOriginal('user_id')) {
                $user = $model->user;
                $model->user_name = $user->name;
                $model->user_email = $user->email;
                $model->user_phone = $user->phone;
                $model->user_birth_place = $user->birth_place;
                $model->user_birth_date = $user->birth_date;
                $model->user_gender = $user->gender;
                $model->user_religion = $user->religion;
                $model->user_company_name = $user->company_name;
            }
        });

        self::deleted(function ($model) {
            $attendance = $model->offlineCourseAttendance;
            if (!empty($attendance)) {
                $attendance->delete();
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

    public function offlineCourseAttendance()
    {
        return $this->hasOne(OfflineCourseAttendance::class, 'offline_course_registrar_id', 'id');
    }
}
